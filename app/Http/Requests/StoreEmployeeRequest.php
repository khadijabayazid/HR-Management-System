<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:employees,phone',
            'email' => 'required|string|email|max:255|unique:employees,email',
            'national_id' => 'required|string|max:50|unique:employees,national_id',
            'job_title_id' => 'required|exists:job_titles,id',
            'employment_type' => 'required|in:full_time,part_time,temporary',
            'hire_date' => 'required|date',
        ];
    }
}
