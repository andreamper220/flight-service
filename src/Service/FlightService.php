<?php

namespace App\Service;

use App\Entity\Flight;
use App\Entity\FlightPassenger;
use App\Entity\Passenger;
use App\Entity\Status;
use App\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Exception;

class FlightService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $passengerId
     * @param int $flightId
     * @param int $seatNumber
     * @return int
     * @throws Exception
     */
    public function reserve(int $passengerId, int $flightId, int $seatNumber): int
    {
        $reservingFlight = new FlightPassenger;

        $this->entityManager->beginTransaction();
        try {
            $reservingFlight
                ->setFlight($this->entityManager->getRepository(Flight::class)->findOneById($flightId))
                ->setPassenger($this->entityManager->getRepository(Passenger::class)->findOneById($passengerId))
                ->setSeatNumber($seatNumber)
                ->setStatus($this->entityManager->getRepository(Status::class)->findOneById(Status::IS_RESERVED));
            $this->entityManager->persist($reservingFlight);
            $this->entityManager->flush();

            $this->entityManager->commit();
        } catch (Exception $exception) {
            $this->entityManager->rollback();
            throw new Exception("Ошибка при резервировании");
        }

        return $flightId;
    }

    /**
     * @param int $passengerId
     * @param int $flightId
     * @return int
     * @throws ORMException
     * @throws Exception
     */
    public function cancel(int $passengerId, int $flightId): int
    {
        /** @var FlightPassenger $cancellingFlight */
        $cancellingFlight = $this->entityManager->getRepository(FlightPassenger::class)->findOneById($this->getFlightPassengerId($passengerId, $flightId));
        if ($cancellingFlight->getTicket()) {
            /** @var Ticket $cancellingTicket */
            $cancellingTicket = $this->entityManager->getRepository(Ticket::class)->findOneById($cancellingFlight->getTicket()->getId());
        }

        $this->entityManager->beginTransaction();
        try {
            $cancellingFlight->setStatus($this->entityManager->getReference(Status::class, Status::IS_CANCELLED));
            if (isset($cancellingTicket)) {
                $cancellingTicket->setIsArchive(true);
            }

            $this->entityManager->flush();

            $this->entityManager->commit();
        } catch (Exception $exception) {
            $this->entityManager->rollback();
            throw new Exception("Ошибка при отмене брони");
        }

        return $flightId;
    }

    /**
     * @param int $passengerId
     * @param int $flightId
     * @param int $seatNumber
     * @return int
     * @throws ORMException
     * @throws Exception
     */
    public function buy(int $passengerId, int $flightId, int $seatNumber): int
    {
        /** @var FlightPassenger $flightToBuy */
        $flightToBuy = $this->entityManager->getRepository(FlightPassenger::class)->findOneById($this->getFlightPassengerId($passengerId, $flightId));
        $newTicket = new Ticket();

        $this->entityManager->beginTransaction();
        try {
            $this->entityManager->persist($newTicket);
            $flightToBuy
                ->setSeatNumber($seatNumber)
                ->setStatus($this->entityManager->getReference(Status::class, Status::IS_APPROVED))
                ->setTicket($newTicket);
            $this->entityManager->flush();

            $this->entityManager->commit();
        } catch (Exception $exception) {
            $this->entityManager->rollback();
            throw new Exception("Ошибка при покупке билета");
        }

        return $newTicket->getId();
    }

    /**
     * @param int $passengerId
     * @param int $flightId
     * @return int
     * @throws ORMException
     * @throws Exception
     */
    private function getFlightPassengerId(int $passengerId, int $flightId): int
    {
        /** @var FlightPassenger $flightPassenger */
        $flightPassenger = $this->entityManager->getRepository(FlightPassenger::class)->findOneBy([
            'flight' => $this->entityManager->getReference(Flight::class, $flightId),
            'passenger' => $this->entityManager->getReference(Passenger::class, $passengerId)
        ]);

        if (!$flightPassenger) {
            $flightPassenger = new FlightPassenger();

            $this->entityManager->beginTransaction();
            try {
                $flightPassenger
                    ->setFlight($this->entityManager->getReference(Flight::class, $flightId))
                    ->setPassenger($this->entityManager->getReference(Passenger::class, $passengerId))
                    ->setStatus($this->entityManager->getReference(Status::class, Status::IS_RESERVED));
                $this->entityManager->persist($flightPassenger);
                $this->entityManager->flush();

                $this->entityManager->commit();
            } catch (Exception $exception) {
                $this->entityManager->rollback();
                throw new Exception("Ошибка при создании записи брони");
            }
        }

        return $flightPassenger->getId();
    }
}
