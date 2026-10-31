<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBuildingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'college_id' => 'required|exists:colleges,id',
            'name' => [
                'required','string','max:300',
                Rule::unique('buildings', 'name')
                    ->where('college_id', $this->college_id)
            ],
            'code' => [
                'required','string','max:50',
                Rule::unique('buildings', 'code')
                    ->where('college_id', $this->college_id)
            ],
            
            // Operating Hours
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time'
        ];
    }
}
