<?php

namespace App\Entity;

use App\Repository\FlightRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FlightRepository::class)
 */
class Flight
{
    public function __construct() {
        $this->passengers = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Place
     * @ORM\ManyToOne(targetEntity="App\Entity\Place")
     * @ORM\JoinColumn(name="departure_id", referencedColumnName="id")
     */
    private $departure;

    /**
     * @var Place
     * @ORM\ManyToOne(targetEntity="App\Entity\Place")
     * @ORM\JoinColumn(name="destination_id", referencedColumnName="id")
     */
    private $destination;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="App\Entity\Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    private $company;

    /**
     * @ORM\Column(type="integer")
     */
    private $seatCount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeparture(): ?Place
    {
        return $this->departure;
    }

    public function setDeparture(Place $departure): self
    {
        $this->departure = $departure;

        return $this;
    }

    public function getDestination(): ?Place
    {
        return $this->destination;
    }

    public function setDestination(Place $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getSeatCount(): ?int
    {
        return $this->seatCount;
    }

    public function setSeatCount(int $seatCount): self
    {
        $this->seatCount = $seatCount;

        return $this;
    }
}
