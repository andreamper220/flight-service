<?php

namespace App\Entity;

use App\Repository\FlightPassengerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass=FlightPassengerRepository::class)
 */
class FlightPassenger
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Flight
     * @ORM\ManyToOne(targetEntity="App\Entity\Flight")
     * @ORM\JoinColumn(name="flight_id", referencedColumnName="id")
     */
    private $flight;

    /**
     * @var Passenger
     * @ORM\ManyToOne(targetEntity="App\Entity\Passenger")
     * @ORM\JoinColumn(name="passenger_id", referencedColumnName="id")
     */
    private $passenger;

    /**
     * @var Status
     * @ORM\ManyToOne(targetEntity="App\Entity\Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    private $status;

    /**
     * @var Ticket
     * @ORM\ManyToOne(targetEntity="App\Entity\Ticket")
     * @ORM\JoinColumn(name="ticket_id", referencedColumnName="id")
     */
    private $ticket = null;

    /**
     * @Assert\Range(
     *     min = 1,
     *     max = 150,
     *     notInRangeMessage="Ваше место должно быть > 0 и <= 150"
     * )
     * @ORM\Column(type="integer", nullable=true)
     */
    private $seatNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFlight(): ?Flight
    {
        return $this->flight;
    }

    public function setFlight(Flight $flight): self
    {
        $this->flight = $flight;

        return $this;
    }

    public function getPassenger(): ?Passenger
    {
        return $this->passenger;
    }

    public function setPassenger(Passenger $passenger): self
    {
        $this->passenger = $passenger;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSeatNumber(): ?int
    {
        return $this->seatNumber;
    }

    public function setSeatNumber(?int $seatNumber): self
    {
        $this->seatNumber = $seatNumber;

        return $this;
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(?Ticket $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }
}
