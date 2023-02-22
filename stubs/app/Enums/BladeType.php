<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self create()
 * @method static self edit()
 * @method static self show()
 * @method static self index()
 */
class BladeType extends Enum
{
    protected static function values(): array
    {
        return [
            'create' => 'create',
            'edit'   => 'edit',
            'show'   => 'show',
            'index'  => 'index',
        ];
    }

    protected static function labels(): array
    {
        return [
            'create' => __('Create'),
            'edit'   => __('Edit'),
            'show'   => __('Show'),
            'index'  => __('Index'),
        ];
    }

    public static function options(): array
    {
        return [
            self::create()->value => __('Create'),
            self::edit()->value   => __('Edit'),
            self::show()->value   => __('Show'),
            self::index()->value  => __('Index'),
        ];
    }

    public static function filters(): array
    {
        return [
            ''                    => __('All'),
            self::create()->value => __('Create'),
            self::edit()->value   => __('Edit'),
            self::show()->value   => __('Show'),
            self::index()->value  => __('Index'),
        ];
    }
}
