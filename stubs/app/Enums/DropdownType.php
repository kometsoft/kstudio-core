<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self manual()
 * @method static self table()
 * @method static self data_dictionary()
 */
class DropdownType extends Enum
{
    protected static function values(): array
    {
        return [
            'manual'          => 'manual',
            'table'           => 'table',
            'data_dictionary' => 'data-dictionary',
        ];
    }

    protected static function labels(): array
    {
        return [
            'manual'          => __('Manual'),
            'table'           => __('Table'),
            'data_dictionary' => __('Data Dictionary'),
        ];
    }

    public static function options(): array
    {
        return [
            self::manual()->value          => self::manual()->label,
            self::table()->value           => self::table()->label,
            self::data_dictionary()->value => self::data_dictionary()->label,
        ];
    }
}
