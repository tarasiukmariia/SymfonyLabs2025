<?php

namespace App\EventListener;

use App\Entity\Aircraft;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Events;
use Psr\Log\LoggerInterface;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: Aircraft::class)]
#[AsEntityListener(event: Events::postUpdate, method: 'postUpdate', entity: Aircraft::class)]
class AircraftEntityListener
{
    public function __construct(
        private LoggerInterface $logger
    ) {}

    public function prePersist(Aircraft $aircraft, PrePersistEventArgs $event): void
    {
        if ($aircraft->getRegistrationNumber()) {
            $upperCaseReg = strtoupper($aircraft->getRegistrationNumber());
            $aircraft->setRegistrationNumber($upperCaseReg);
        }

        $this->logger->info("Creating new aircraft: " . $aircraft->getRegistrationNumber());
    }

    public function postUpdate(Aircraft $aircraft, PostUpdateEventArgs $event): void
    {
        $this->logger->info("Aircraft ID " . $aircraft->getId() . " updated successfully at " . date('Y-m-d H:i:s'));
    }
}