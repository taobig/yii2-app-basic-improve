<?php

namespace app\enums;


class EmployeeActiveEnum extends BaseEnum
{
    const ACTIVE = 1;
    const DELETED = 0;

    public static $arr = [
        self::ACTIVE => '有效的',
        self::DELETED => '被删除的',
    ];

    public static function labels(): array
    {
        return self::$arr;
    }


}