<?php

namespace App\Http\Requests\Admin\Experiment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateExperiment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.experiment.edit', $this->experiment);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'ajax_url' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string'],
            'export' => ['nullable', 'boolean'],
            'layout' => ['sometimes', 'array'],
            'slug' => ['nullable', 'string'],
            'title' => ['sometimes', 'string'],
            'graphs' => ['required', 'array'],
            'custom_js' => ['nullable', 'string'],
            'run_button' => ['nullable', 'boolean']

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
        $sanitized['layout_id'] = $sanitized['layout']['id'];
        $sanitized['slug'] = ($sanitized['slug']) ?: str_slug($sanitized['title']);


        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
