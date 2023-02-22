<?php

use App\Enums\YesNo;
use App\Models\Admin\Lookup;
use Illuminate\Support\Facades\Cache;

if (! function_exists('lookup')) {
    function lookup($key)
    {
        return Cache::remember('lookup.'.$key, 60, function () use ($key) {
            return Lookup::where('key', $key)->get();
        });
    }
}

if (! function_exists('lookup_yes_no')) {
    function lookup_yes_no()
    {
        return Cache::rememberForever('lookup.yes.no', function () {
            return YesNo::options();
        });
    }
}
