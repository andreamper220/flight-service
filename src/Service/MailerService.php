<?php

namespace App\Service;

use App\Entity\Flight;
use App\Entity\FlightPassenger;
use App\Entity\Passenger;
use App\Entity\Status;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    /**
     * @param int $flightId
     * @param string $event
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function sendEmailsByFlightId(int $flightId, string $event)
    {
        /** @var FlightPassenger $flight */
        $flights = $this->entityManager->createQueryBuilder()
            ->select('fp')
            ->from(FlightPassenger::class, 'fp')
            ->join('fp.flight', 'flight')
            ->where('flight.id = :flightId')
            ->andWhere('fp.status in :statuses')
            ->setParameters([
                'flightId' => $flightId,
                'statuses' => [Status::IS_APPROVED, Status::IS_RESERVED]
            ])
            ->getQuery()
            ->getResult();
        if (!$flights) {
            throw new Exception('flight is not existed!');
        }

        $passengers = [];
        foreach ($flights as $flight) {
            $passengers[] = $flight->getPassenger();
        }
        try {
            switch ($event) {
                case 'flight_ticket_sales_completed':
                    foreach ($passengers as $passenger) {
                        $email = (new Email())
                            ->from('flight-company@example.com')
                            ->to($passenger->getEmail())
                            ->subject('Your flight is sold out!')
                            ->text('Your flight is sold out!');

                        $this->mailer->send($email);
                    }

                    break;
                case 'flight_cancelled':
                    foreach ($passengers as $passenger) {
                        $email = (new Email())
                            ->from('flight-company@example.com')
                            ->to($passenger->getEmail())
                            ->subject('Your flight is cancelled!')
                            ->text('Your flight is cancelled!');

                        $this->mailer->send($email);
                    }
            }
        } catch (Exception $exception) {
            throw new Exception('sending messages error!');
        }
    }
}
