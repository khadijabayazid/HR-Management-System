<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
        $id = $this->route('employee');
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:employees,phone,$id',
            'email' => 'required|string|email|max:255|unique:employees,email,$id',
            'national_id' => 'required|string|max:50|unique:employees,national_id,$id',
            'job_title_id' => 'required|exists:job_titles,id',
            'employment_type' => 'in:full_time,part_time,temporary|nullable',
            'hire_date' => 'date|nullable',
        ];
    }
}
