<?php

use App\Enums\BladeType;
use App\Enums\DropdownType;
use App\Models\MyStudio\MyStudio;
use App\Models\MyStudio\Tab;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

const NEW_LINE    = "\n";
const NEW_LINE_2  = "\n\n";
const SEPARATOR   = "\t";
const SEPARATOR_2 = "\t\t";
const SEPARATOR_3 = "\t\t\t";
const SEPARATOR_4 = "\t\t\t\t";
const SEPARATOR_5 = "\t\t\t\t\t";
const SEPARATOR_6 = "\t\t\t\t\t\t";
const SEPARATOR_7 = "\t\t\t\t\t\t\t";
const SEPARATOR_8 = "\t\t\t\t\t\t\t\t";

if (!function_exists('form_content')) {
    function form_content($form_id, $form_fields, $type = null)
    {
        $content = NEW_LINE;

        if (!empty($form_fields)) {
            foreach ($form_fields as $index => $field) {
                $value    = '';
                $readonly = '';

                if ($type == BladeType::edit() || $type == BladeType::show()) {
                    $value = 'value="{{ $model->' . $field['column_name'] . ' ?? \'\' }}"';
                }

                if ($type == BladeType::show()) {
                    $readonly = ' readonly="readonly"';
                }

                if ($field['type'] == 'text' || $field['type'] == 'email' || $field['type'] == 'file' || $field['type'] == 'date' || $field['type'] == 'number') {

                    $content .= SEPARATOR_6 . '<x-forms.input ' . $value . $readonly . ' label="' . $field['label'] . '" type="' . $field['type'] . '" placeholder="' . $field['placeholder'] . '" name="' . $field['column_name'] . '">' . NEW_LINE;
                    $content .= SEPARATOR_6 . '</x-forms.input>' . NEW_LINE_2;

                } elseif ($field['type'] == 'textarea') {

                    $content .= SEPARATOR_6 . '<x-forms.textarea ' . $value . $readonly . ' label="' . $field['label'] . '" name="' . $field['column_name'] . '">' . NEW_LINE;
                    $content .= SEPARATOR_6 . '</x-forms.textarea>' . NEW_LINE_2;

                } elseif ($field['type'] == 'dropdown') {

                    $content .= SEPARATOR_6 . '<x-forms.dropdown ' . $value . $readonly . ' label="' . $field['label'] . '" name="' . $field['column_name'] . '" :options="dropdown_option(' . $form_id . ', ' . $index . ')">' . NEW_LINE;
                    $content .= SEPARATOR_6 . '</x-forms.dropdown>' . NEW_LINE_2;

                } elseif ($field['type'] == 'checkbox') {

                    $content .= SEPARATOR_6 . '<x-forms.checkbox ' . $value . $readonly . ' label="' . $field['label'] . '" name="' . $field['column_name'] . '">' . NEW_LINE;
                    $content .= SEPARATOR_7 . '<x-slot name="option">' . NEW_LINE;

                    foreach ($field['value'] as $value) {
                        $content .= SEPARATOR_8 . '<x-forms.checkbox-value label="' . $value['description'] . '" name="' . $field['column_name'] . '" value="' . $value['value'] . '">' . NEW_LINE;
                        $content .= SEPARATOR_8 . '</x-forms.checkbox-value>' . NEW_LINE;
                    }

                    $content .= SEPARATOR_7 . '</x-slot>' . NEW_LINE;
                    $content .= SEPARATOR_6 . '</x-forms.checkbox>' . NEW_LINE_2;

                } elseif ($field['type'] == 'radio') {

                    $content .= SEPARATOR_6 . '<x-forms.radiobutton ' . $value . $readonly . ' label="' . $field['label'] . '" name="' . $field['column_name'] . '">' . NEW_LINE;
                    $content .= SEPARATOR_7 . '<x-slot name="option">' . NEW_LINE;

                    foreach ($field['value'] as $value) {
                        $content .= SEPARATOR_8 . '<x-forms.radio-value ' . $value . ' label="' . $value['description'] . '" name="' . $field['column_name'] . '" value="' . $value['value'] . '">' . NEW_LINE;
                        $content .= SEPARATOR_8 . '</x-forms.radio-value>' . NEW_LINE;
                    }

                    $content .= SEPARATOR_7 . '</x-slot>' . NEW_LINE;
                    $content .= SEPARATOR_6 . '</x-forms.radiobutton>' . NEW_LINE_2;

                } else {

                    $content .= SEPARATOR_6 . '<p>Unidentified Input</p>' . NEW_LINE_2;

                }
            }
        }

        return $content;
    }
}

if (!function_exists('blade_content')) {
    function blade_content($form_id)
    {
        $form = MyStudio::find($form_id);
        $name = Str::of($form->name)->singular()->lower()->kebab();

        $form_fields = $form->settings['formDetails'];

        return [
            'name'           => $name ?? '',
            'id'             => $form->id ?? '',
            'title'          => Str::of($name ?? '')->ucfirst(),
            'title_plural'   => Str::of($name ?? '')->plural()->ucfirst(),
            'content_create' => form_content($form_id, $form_fields, BladeType::create()) ?? '',
            'content_edit'   => form_content($form_id, $form_fields, BladeType::edit()) ?? '',
            'content_show'   => form_content($form_id, $form_fields, BladeType::show()) ?? '',
        ];
    }
}

if (!function_exists('form_navigator')) {
    function form_navigator($form_id, $is_show = false)
    {
        // Initialize
        $navigators  = [];
        $parent_id   = request()->get('parent_id');
        $parent_form = request()->get('parent_form');

        if (!empty($parent_id) && !empty($parent_form)) {
            $form_id = $parent_form;
            $is_show = true;
        } else if ($is_show) {
            $parent_id = last(request()->segments());
        }

        if ($is_show) {
            $form = MyStudio::find($form_id);

            $tab = Tab::where('settings->form_id', $form_id)->first();

            if (!empty($tab->settings['subtab'])) {
                $param = '?parent_id=' . $parent_id . '&parent_form=' . $form_id;

                if ($is_show) {
                    $uri = route('mystudio.' . Str::of($form['name'])->singular()->kebab() . '.show', $parent_id);

                    $navigators[$uri] = '*' . $form['name'];
                }

                foreach ($tab->settings['subtab'] as $subtab) {
                    $uri = route('mystudio.' . Str::of($subtab['table'])->singular()->kebab() . '.index') . $param;

                    $navigators[$uri] = $subtab['title'];
                }
            }

            $data = [
                'navigators' => $navigators,
            ];

            return view('partials.form_navigator', $data);
        }
    }
}

if (!function_exists('dropdown_option')) {
    function dropdown_option($form_id, $index)
    {
        $form   = MyStudio::where('id', $form_id)->first();
        $fields = data_get($form->settings, 'formDetails');
        $field  = data_get($fields, $index);

        $options = [];
        $type    = data_get($field, 'option_type');
        $values  = data_get($field, 'value');

        if ($type == DropdownType::manual()) {
            $options = collect($values)->pluck('description', 'value')->all();
        } else if ($type == DropdownType::table()) {
            $value_column = data_get($values, 'value_column');
            $label_column = data_get($values, 'description_column');
            $ref_table    = data_get($values, 'reference_table');

            $options = DB::table($ref_table)->get()->pluck($label_column, $value_column)->all();
        } else if ($type == DropdownType::data_dictionary()) {
            $key = data_get($values, 'lookup_type');

            $options = lookup($key)->pluck('value_local', 'id')->all();
        }

        return $options;
    }
}
