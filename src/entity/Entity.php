<?php

namespace Farhanisty\Mariana\Entity;

interface Entity
{
    public function toArray(Entity $data): array;
    public static function arrayToObject(array $data): Entity;
}
