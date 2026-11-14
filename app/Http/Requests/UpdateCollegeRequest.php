<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCollegeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $collegeId = $this->route('college_id');

        return [
            'name' => ['required', 'string', 'max:300', Rule::unique('colleges', 'name')->ignore($collegeId)],
            'code' => ['required', 'string', 'max:50', Rule::unique('colleges', 'code')->ignore($collegeId)]
        ];
    }
}
