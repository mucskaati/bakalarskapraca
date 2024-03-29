<?php

namespace App\Http\Requests\Admin\Slider;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateSlider extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.slider.edit', $this->slider);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'default' => ['nullable', 'numeric'],
            'default_function' => ['nullable', 'string'],
            'layout' => ['required_if:type,fo'],
            'comparison_experiments' => ['required_if:type,comparison'],
            'max' => ['sometimes', 'numeric'],
            'min' => ['sometimes', 'numeric'],
            'step' => ['sometimes', 'numeric'],
            'title' => ['sometimes', 'string'],
            'label' => ['required', 'string'],
            'columns' => ['required', 'integer'],
            'sorting' => ['required', 'integer'],
            'visible' => ['nullable', 'boolean'],
            'dependencies' => ['nullable', 'array'],
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
        $sanitized = collect($this->validated())->except(['dependencies'])->toArray();
        $sanitized['layout_id'] = ($sanitized['layout']) ? $sanitized['layout']['id'] : null;


        //Add your code for manipulation with request data here

        return $sanitized;
    }

    /**
     * Get dependencies
     *
     * @return array
     */
    public function getDependencies(): array
    {
        $sanitized = collect($this->validated())->only(['dependencies'])->toArray();
        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
