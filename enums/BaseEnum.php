<?php

namespace app\enums;


abstract class BaseEnum
{

    abstract public static function labels(): array;

    public static function label($status)
    {
        return static::labels()[$status] ?? $status;
    }

    public static function exists($type): bool
    {
        return isset(static::labels()[$type]);
    }

}