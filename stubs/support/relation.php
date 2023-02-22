<?php

use App\Models\MyStudio\Tab;
use Illuminate\Support\Str;

if (!function_exists('update_relation')) {
    function update_relation($model, $request)
    {
        if (data_get($request, 'parent_id') && data_get($request, 'parent_form')) {
            $tab     = Tab::where('settings->form_id', data_get($request, 'parent_form'))->first();
            $current = $model->getTable();
            $table   = collect(data_get($tab->settings, 'subtab'))->where('table', $current)->first();
            $class   = '\App\Models\MyStudio\\' . Str::of($table['parent_table'])->singular()->camel()->ucfirst();
            $record  = $class::whereUuid(data_get($request, 'parent_id'))->first();

            if ($table['relation_type'] == 'hasMany') {
                $model->update([
                    $table['foreign_key'] => data_get($record, 'id'),
                ]);
            } else if ($table['relation_type'] == 'belongsToMany') {
                if (method_exists($model, $table['parent_table'])) {
                    $method = $table['parent_table'];

                    $model->$method()->attach($record->id);
                }
            }
        }
    }
}

if (!function_exists('extend_param')) {
    function extend_param($request)
    {
        $param = '';

        if (!empty(data_get($request, 'parent_id')) || !empty(data_get($request, 'parent_form'))) {
            $param = '?';
            $param .= (!empty(data_get($request, 'parent_id'))) ? 'parent_id=' . data_get($request, 'parent_id') . '&' : '';
            $param .= (!empty(data_get($request, 'parent_form'))) ? 'parent_form=' . data_get($request, 'parent_form') : '';
        }

        return $param;
    }
}
