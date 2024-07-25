<?php

namespace App\Interface;

interface CustomeEntityManagerInterface
{
    public function add(object $entity, ?bool $flush = false): void;

    public function remove(object $entity, ?bool $flush = false): void;
}