<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Controller\ElectrovalveCreationController;
use App\Repository\ElectrovalveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ElectrovalveRepository::class)]
#[ApiResource(
    operations: [
        'post' => [
            'controller' => ElectrovalveCreationController::class,
        ],
    ],
    normalizationContext: ['groups' => ['electrovalve:read']],
    denormalizationContext: ['groups' => ['electrovalve:write']],
)]

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

    #[ORM\OneToOne(targetEntity: ValveSettings::class, mappedBy: "electrovalve", cascade: ["persist", "remove"])]
    #[Groups(['electrovalve:read', 'electrovalve:write'])]
    private ?ValveSettings $valveSettings;

    #[ORM\OneToMany(mappedBy: 'electrovalve', targetEntity: Irrigation::class, orphanRemoval: true)]
    private Collection $irrigations;

    public function __construct()
    {
        $this->irrigations = new ArrayCollection();
    }

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

    public function getValveSettings(): ?ValveSettings
    {
        return $this->valveSettings;
    }

    public function setValveSettings(ValveSettings $valveSettings): static
    {
        // set the owning side of the relation if necessary
        if ($valveSettings->getElectrovalve() !== $this) {
            $valveSettings->setElectrovalve($this);
        }

        $this->valveSettings = $valveSettings;

        return $this;
    }

    /**
     * @return Collection<int, Irrigation>
     */
    public function getIrrigations(): Collection
    {
        return $this->irrigations;
    }

    public function addIrrigation(Irrigation $irrigation): static
    {
        if (!$this->irrigations->contains($irrigation)) {
            $this->irrigations->add($irrigation);
            $irrigation->setElectrovalve($this);
        }

        return $this;
    }

    public function removeIrrigation(Irrigation $irrigation): static
    {
        if ($this->irrigations->removeElement($irrigation)) {
            // set the owning side to null (unless already changed)
            if ($irrigation->getElectrovalve() === $this) {
                $irrigation->setElectrovalve(null);
            }
        }

        return $this;
    }
}
