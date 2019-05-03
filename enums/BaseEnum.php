<?php

namespace app\enums;


abstract class BaseEnum
{

    abstract public static function labels(): array;

    public static function label($val)
    {
        return static::labels()[$val] ?? $val;
    }

    public static function exists($va): bool
    {
        return isset(static::labels()[$va]);
    }

}