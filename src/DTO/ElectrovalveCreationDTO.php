<?php

namespace App\DTO;

class ElectrovalveCreationDTO
{
    public ?string $name = null;
    public ?int $position = null;
    public ?bool $isAutomatic = null;

    // ValveSettings data
    public ?float $rainThreshold = null;
    public ?float $moistureThreshold = null;
    public ?int $duration = null;

    // Schedules data - a list of schedules
    public array $schedules = [];
}


