<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\Groups;

class ElectrovalveCreationDTO
{
    #[Groups('user:write')]
    public ?string $name = null;
    #[Groups('user:write')]
    public ?int $position = null;
    #[Groups('user:write')]
    public ?bool $isAutomatic = null;

    // ValveSettings data
    #[Groups('user:write')]
    public ?float $rainThreshold = null;
    #[Groups('user:write')]
    public ?float $moistureThreshold = null;
    #[Groups('user:write')]
    public ?int $duration = null;

    // Schedules data - a list of schedules
    #[Groups('user:write')]
    public array $schedules = [];
}


