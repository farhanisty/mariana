<?php

namespace Farhanisty\Mariana;

class Harem
{
    public static function manipulate(array $copyArray, array $changer)
    {
        $array = $copyArray;

        $keys = array_keys($changer);
        $values = array_values($changer);

        foreach ($values as $value) {
            foreach ($keys as $key) {
                $array[$value] = $array[$key];
            }
        }

        return $array;
    }
}
