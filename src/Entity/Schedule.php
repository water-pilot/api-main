<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ScheduleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
#[ApiResource]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $hourStart = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $hourEnd = null;

    #[ORM\Column(length: 50)]
    private ?string $day = null;

    #[ORM\Column]
    private ?bool $isActivated = null;

    #[ORM\ManyToOne(inversedBy: 'schedules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ValveSettings $valveSettings = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHourStart(): ?int
    {
        return $this->hourStart;
    }

    public function setHourStart(int $hourStart): static
    {
        $this->hourStart = $hourStart;

        return $this;
    }

    public function getHourEnd(): ?int
    {
        return $this->hourEnd;
    }

    public function setHourEnd(int $hourEnd): static
    {
        $this->hourEnd = $hourEnd;

        return $this;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function isIsActivated(): ?bool
    {
        return $this->isActivated;
    }

    public function setIsActivated(bool $isActivated): static
    {
        $this->isActivated = $isActivated;

        return $this;
    }

    public function getValveSettings(): ?ValveSettings
    {
        return $this->valveSettings;
    }

    public function setValveSettings(?ValveSettings $valveSettings): static
    {
        $this->valveSettings = $valveSettings;

        return $this;
    }
}
