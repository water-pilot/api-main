<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\IrrigationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IrrigationRepository::class)]
#[ApiResource]
class Irrigation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateStart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEnd = null;

    #[ORM\Column(nullable: true)]
    private ?int $volume = null;

    #[ORM\ManyToOne(inversedBy: 'irrigations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Electrovalve $electrovalve = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): static
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): static
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getVolume(): ?int
    {
        return $this->volume;
    }

    public function setVolume(?int $volume): static
    {
        $this->volume = $volume;

        return $this;
    }

    public function getElectrovalve(): ?Electrovalve
    {
        return $this->electrovalve;
    }

    public function setElectrovalve(?Electrovalve $electrovalve): static
    {
        $this->electrovalve = $electrovalve;

        return $this;
    }
}
