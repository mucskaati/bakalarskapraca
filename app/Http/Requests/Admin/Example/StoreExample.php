<?php

namespace App\Http\Requests\Admin\Example;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreExample extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.example.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'experiment' => ['required', 'array'],
            'title' => ['required', 'string'],
            'sliders' => ['nullable', 'array'],
            'checkboxes' => ['nullable', 'array'],
            'schemes' => ['nullable', 'array'],

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
        $sanitized['experiment_id'] = $sanitized['experiment']['id'];

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
