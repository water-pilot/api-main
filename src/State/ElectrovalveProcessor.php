<?php

namespace App\State;

use ApiPlatform\Metadata\DeleteOperationInterface;
use App\Entity\Electrovalve;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Psr\Log\LoggerInterface;

class ElectrovalveProcessor implements ProcessorInterface
{
    private $tokenStorage;
    private $persistProcessor;
    private $removeProcessor;
    private $logger;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        ProcessorInterface $persistProcessor,
        ProcessorInterface $removeProcessor,
        LoggerInterface $logger
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->persistProcessor = $persistProcessor;
        $this->removeProcessor = $removeProcessor;
        $this->logger = $logger;
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        // Handle POST operation
        if (str_contains($operation->getName(), 'post') && $data instanceof Electrovalve) {
            // Get the User object
            $token = $this->tokenStorage->getToken();
            if (null !== $token) {
                $user = $token->getUser();

                // Set the user in the electrovalve
                $data->setUser($user);
            }

            return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        }

        // Handle PATCH operation
        if (str_contains($operation->getName(), 'patch') && $data instanceof Electrovalve) {
            // Ici, vous pouvez ajouter la logique pour gérer l'opération PATCH
            // Par exemple, mise à jour de certaines propriétés, validation, etc.
            return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        }

        // Handle DELETE operation
        if ($operation instanceof DeleteOperationInterface && $data instanceof Electrovalve) {
            return $this->removeProcessor->process($data, $operation, $uriVariables, $context);
        }

        // If neither POST nor DELETE, you might want to throw an exception or handle other operations as needed.
    }
}
