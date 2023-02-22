<?php

namespace App\Http\Requests\TableField;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge(['name' => Str::of(request('name'))->lower()->plural()]);

        request()->request->set('name', Str::of(request('name'))->lower()->plural());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'unique:my_studio,name,NULL,id,type,"table"'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('Table Name')]),
            'name.unique'   => __('validation.unique', ['attribute' => __('Table Name')]),
        ];
    }
}
