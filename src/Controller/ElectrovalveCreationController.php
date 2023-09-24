<?php

namespace App\Controller;

use App\DTO\ElectrovalveCreationDTO;
use App\Entity\Electrovalve;
use App\Entity\Schedule;
use App\Entity\ValveSettings;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ElectrovalveCreationController
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function __invoke(ElectrovalveCreationDTO $data, EntityManagerInterface $em): Electrovalve
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = $this->tokenStorage->getToken()->getUser();

        $electrovalve = new Electrovalve();
        $electrovalve
            ->setName($data->name)
            ->setPosition($data->position)
            ->setIsAutomatic($data->isAutomatic)
            ->setUser($user); // Associer l'utilisateur à l'Electrovalve

        $valveSettings = new ValveSettings();
        $valveSettings
            ->setRainThreshold($data->rainThreshold)
            ->setMoistureThreshold($data->moistureThreshold)
            ->setDuration($data->duration)
            ->setElectrovalve($electrovalve);

        $electrovalve->setValveSettings($valveSettings);

        foreach ($data->schedules as $scheduleData) {
            $schedule = new Schedule();
            $schedule
                ->setHourStart($scheduleData['hourStart'])
                ->setHourEnd($scheduleData['hourEnd'])
                ->setDay($scheduleData['day'])
                ->setIsActivated($scheduleData['isActivated'])
                ->setValveSettings($valveSettings);
            $valveSettings->addSchedule($schedule);
        }

        $em->persist($electrovalve);
        $em->flush();

        return $electrovalve;
    }
}
