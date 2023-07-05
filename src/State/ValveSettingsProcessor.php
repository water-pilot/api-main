<?php
namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Repository\ElectrovalveRepository;
use Psr\Log\LoggerInterface;
use App\Entity\ValveSettings;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ValveSettingsProcessor implements ProcessorInterface
{
    private $tokenStorage;
    private $electrovalveRepository;
    private $logger;
    private $persistProcessor;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        ElectrovalveRepository $electrovalveRepository,
        LoggerInterface $logger,
        ProcessorInterface $persistProcessor
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->electrovalveRepository = $electrovalveRepository;
        $this->logger = $logger;
        $this->persistProcessor = $persistProcessor;
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $this->logger->error('je suis là............');

        if (str_contains($operation->getName(), 'post')  && $data instanceof ValveSettings) {
            $this->logger->error('je suis rentré............');
            $token = $this->tokenStorage->getToken();
            if (null !== $token) {
                $user = $token->getUser();

                $electrovalve = $this->electrovalveRepository->find($data->getElectrovalve()->getId());
                $this->logger->info('Electrovalve id: ' . $electrovalve->getId());

                if ($electrovalve->getUser() !== $user) {
                    $this->logger->error('Electrovalve does not belong to the authenticated user.');
                    throw new AccessDeniedException('Electrovalve does not belong to the authenticated user.');
                }

                $result = $this->persistProcessor->process($data, $operation, $uriVariables, $context);
                return $result;
            }
        }
    }
}
