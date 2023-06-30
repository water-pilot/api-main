<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ElectrovalveRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ElectrovalveRepository::class)]
#[ApiResource]
class Electrovalve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $position = null;

    #[ORM\Column]
    private ?bool $isAutomatic = null;

    #[ORM\ManyToOne(inversedBy: 'electrovalves')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function isIsAutomatic(): ?bool
    {
        return $this->isAutomatic;
    }

    public function setIsAutomatic(bool $isAutomatic): static
    {
        $this->isAutomatic = $isAutomatic;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
