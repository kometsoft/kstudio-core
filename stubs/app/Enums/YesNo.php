<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self yes()
 * @method static self no()
 */
class YesNo extends Enum
{
    protected static function values(): array
    {
        return [
            'yes' => true,
            'no'  => false,
        ];
    }

    protected static function labels(): array
    {
        return [
            'yes' => __('Yes'),
            'no'  => __('No'),
        ];
    }

    public static function options(): array
    {
        return [
            self::yes()->value => __('Yes'),
            self::no()->value  => __('No'),
        ];
    }
}
