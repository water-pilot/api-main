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

        if (str_contains($operation->getName(), 'post') && $data instanceof Electrovalve) {

            // Get the User object
            $token = $this->tokenStorage->getToken();
            if (null !== $token) {
                $user = $token->getUser();

                // Set the user in the electrovalve
                $data->setUser($user);
            }

            if ($operation instanceof DeleteOperationInterface) {
                return $this->removeProcessor->process($data, $operation, $uriVariables, $context);
            }

            $result = $this->persistProcessor->process($data, $operation, $uriVariables, $context);
            return $result;
        }
    }
}
