<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 */
class Document
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DocumentType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * @var DocumentType
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $series;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Passenger")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     * @var Passenger
     */
    private $owner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?DocumentType
    {
        return $this->type;
    }

    public function setType(DocumentType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSeries(): ?string
    {
        return $this->series;
    }

    public function setSeries(?string $series): self
    {
        $this->series = $series;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return Passenger
     */
    public function getOwner(): Passenger
    {
        return $this->owner;
    }

    /**
     * @param Passenger $owner
     * @return Document
     */
    public function setOwner(Passenger $owner): Document
    {
        $this->owner = $owner;

        return $this;
    }
}
