<?php

namespace App\Service;

use App\Interface\CustomeEntityManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

class CustomeEntityManagerService implements CustomeEntityManagerInterface
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function add(object $entity, ?bool $flush = false): void
    {
        $this->entityManager->persist($entity);

        if ($flush) {
            $this->entityManager->flush();
        }
    }

    public function remove(object $entity, ?bool $flush = false): void
    {
        $this->entityManager->remove($entity);

        if ($flush) {
            $this->entityManager->flush();
        }
    }
}
