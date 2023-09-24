<?php

namespace App\Controller;

use App\DTO\ElectrovalveCreationDTO;
use App\Entity\Electrovalve;
use App\Entity\Schedule;
use App\Entity\ValveSettings;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsController]
class ElectrovalveCreationController
{
    private TokenStorageInterface $tokenStorage;

    private LoggerInterface $logger;

    public function __construct(TokenStorageInterface $tokenStorage, LoggerInterface $logger)
    {
        $this->tokenStorage = $tokenStorage;
        $this->logger = $logger;
    }

    public function __invoke(ElectrovalveCreationDTO $data, EntityManagerInterface $em): Electrovalve
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = $this->tokenStorage->getToken()->getUser();
        $this->logger->info('Request Body:', ['data' => $data]);

        $electrovalve = new Electrovalve();

        if ($data->name !== null) {
            $electrovalve->setName($data->name);
        }

        if ($data->position !== null) {
            $electrovalve->setPosition($data->position);
        }

        if ($data->isAutomatic !== null) {
            $electrovalve->setIsAutomatic($data->isAutomatic);
        }

        $electrovalve->setUser($user); // Associer l'utilisateur à l'Electrovalve

        $valveSettings = new ValveSettings();

        if ($data->rainThreshold !== null) {
            $valveSettings->setRainThreshold($data->rainThreshold);
        }

        if ($data->moistureThreshold !== null) {
            $valveSettings->setMoistureThreshold($data->moistureThreshold);
        }

        if ($data->duration !== null) {
            $valveSettings->setDuration($data->duration);
        }

        $valveSettings->setElectrovalve($electrovalve);

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
