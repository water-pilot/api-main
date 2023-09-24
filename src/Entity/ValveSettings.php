<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ValveSettingsRepository;
use App\State\ValveSettingsProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ValveSettingsRepository::class)]
#[ApiResource(
    processor: ValveSettingsProcessor::class,
)]
class ValveSettings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['user:read', 'user:write'])]
    #[ORM\Column]
    private ?float $rainThreshold = null;
    #[Groups(['user:read', 'user:write'])]
    #[ORM\Column]
    private ?float $moistureThreshold = null;
    #[Groups(['user:read', 'user:write'])]
    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\OneToOne(inversedBy: 'valveSettings', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Electrovalve $electrovalve = null;

    #[Groups(['user:read', 'user:write'])]
    #[ORM\OneToMany(mappedBy: 'valveSettings', targetEntity: Schedule::class, cascade: ['persist'], orphanRemoval:
        true)]
    private Collection $schedules;

    public function __construct()
    {
        $this->schedules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRainThreshold(): ?float
    {
        return $this->rainThreshold;
    }

    public function setRainThreshold(float $rainThreshold): static
    {
        $this->rainThreshold = $rainThreshold;

        return $this;
    }

    public function getMoistureThreshold(): ?float
    {
        return $this->moistureThreshold;
    }

    public function setMoistureThreshold(float $moistureThreshold): static
    {
        $this->moistureThreshold = $moistureThreshold;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getElectrovalve(): ?Electrovalve
    {
        return $this->electrovalve;
    }

    public function setElectrovalve(Electrovalve $electrovalve): static
    {
        $this->electrovalve = $electrovalve;

        return $this;
    }

    /**
     * @return Collection<int, Schedule>
     */
    public function getSchedules(): Collection
    {
        return $this->schedules;
    }

    public function addSchedule(Schedule $schedule): static
    {
        if (!$this->schedules->contains($schedule)) {
            $this->schedules->add($schedule);
            $schedule->setValveSettings($this);
        }

        return $this;
    }

    public function removeSchedule(Schedule $schedule): static
    {
        if ($this->schedules->removeElement($schedule)) {
            // set the owning side to null (unless already changed)
            if ($schedule->getValveSettings() === $this) {
                $schedule->setValveSettings(null);
            }
        }

        return $this;
    }
}
