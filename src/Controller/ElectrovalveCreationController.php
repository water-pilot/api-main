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

        // Validation des champs obligatoires
        if (empty($data->name) || $data->position === null) {
            throw new \InvalidArgumentException("Les champs name et position sont obligatoires.");
        }

        // Validation des heures
        foreach ($data->schedules as $scheduleData) {
            if ($scheduleData['hourStart'] >= $scheduleData['hourEnd']) {
                throw new \InvalidArgumentException("L'heure de début doit être inférieure à l'heure de fin.");
            }
            if ($scheduleData['hourStart'] < 0 || $scheduleData['hourStart'] > 24 || $scheduleData['hourEnd'] < 0 || $scheduleData['hourEnd'] > 24) {
                throw new \InvalidArgumentException("Les heures fournies doivent être entre 0 et 24.");
            }
        }

        // Validation des jours
        $validDays = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];
        foreach ($data->schedules as $scheduleData) {
            foreach ($scheduleData['day'] as $day) {
                if (!in_array($day, $validDays)) {
                    throw new \InvalidArgumentException("Jour invalide : $day");
                }
            }
            if (count($scheduleData['day']) !== count(array_unique($scheduleData['day']))) {
                throw new \InvalidArgumentException("Des jours en double ont été fournis.");
            }
        }

        // Validation de la position et de la durée
        if ($data->position < 0) {
            throw new \InvalidArgumentException("La position doit être un nombre positif.");
        }
        if ($data->duration !== null && $data->duration < 0) {
            throw new \InvalidArgumentException("La durée doit être un nombre positif.");
        }

        // Création de l'électrovanne
        $electrovalve = new Electrovalve();
        $electrovalve->setName($data->name)
            ->setPosition($data->position)
            ->setIsAutomatic($data->isAutomatic)
            ->setUser($user);

        // Création des paramètres de l'électrovanne
        $valveSettings = new ValveSettings();
        $valveSettings->setRainThreshold($data->rainThreshold)
            ->setMoistureThreshold($data->moistureThreshold)
            ->setDuration($data->duration)
            ->setElectrovalve($electrovalve);

        $electrovalve->setValveSettings($valveSettings);

        // Création des horaires
        foreach ($data->schedules as $scheduleData) {
            $schedule = new Schedule();
            $schedule->setHourStart($scheduleData['hourStart'])
                ->setHourEnd($scheduleData['hourEnd'])
                ->setDays($scheduleData['day'])
                ->setIsActivated($scheduleData['isActivated'])
                ->setValveSettings($valveSettings);
            $valveSettings->addSchedule($schedule);
        }

        $em->persist($electrovalve);
        $em->flush();

        return $electrovalve;
    }
}
