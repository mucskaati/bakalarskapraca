<?php

namespace App\Http\Requests\Admin\Layout;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreLayout extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.layout.create');
    }

    /**
     * Get the validation rules that apply to the requests untranslatable fields.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'columns' => ['nullable', 'integer'],
            'height' => ['nullable', 'numeric'],
            'name' => ['required', 'string'],
            'rows' => ['nullable', 'integer'],
            'type' => ['required', 'string'],
            'width' => ['nullable', 'numeric'],
            'margin' => ['nullable', 'string'],
            'xaxis' => ['nullable', 'string'],
            'yaxis' => ['nullable', 'string'],

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

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
