<?php

namespace App\Trait\Entity;

use Doctrine\ORM\Mapping as ORM;

trait DateFields
{
    #[ORM\Column]
    protected \DateTimeImmutable $createdAt;

    #[ORM\Column]
    protected \DateTimeImmutable $updatedAt;

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    protected function create() : void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    protected function update() : void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
