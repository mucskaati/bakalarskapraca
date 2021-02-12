<?php

namespace App\Http\Requests\Admin\Experiment;

use App\Models\Graph;
use App\Models\Trace;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreExperiment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.experiment.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'ajax_url' => ['required', 'string'],
            'description' => ['required', 'string'],
            'export' => ['nullable', 'boolean'],
            'layout' => ['required', 'array'],
            'slug' => ['nullable', 'string'],
            'type' => ['required', 'string'],
            'title' => ['required', 'string'],
            'graphs' => ['required', 'array'],
            'schemes' => ['required_if:type,comparison', 'array'],
            'custom_js' => ['nullable', 'string'],
            'run_button' => ['nullable', 'boolean'],
            'template' => ['nullable', 'string']

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

        return $sanitized;
    }
}
