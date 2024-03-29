<?php

namespace App\Http\Requests\Admin\Checkbox;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateCheckbox extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.checkbox.edit', $this->checkbox);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'attribute_name' => ['sometimes', 'string'],
            'layout' => ['required_if:type,fo'],
            'comparison_experiments' => ['required_if:type,comparison'],
            'title' => ['sometimes', 'string'],
            'slider_dependency_change' => ['required', 'boolean'],
            'dependent_sliders' => ['nullable', 'array'],
            'type' => ['required', 'string'],

        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();
        $sanitized['layout_id'] = ($sanitized['layout']) ? $sanitized['layout']['id'] : null;


        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
