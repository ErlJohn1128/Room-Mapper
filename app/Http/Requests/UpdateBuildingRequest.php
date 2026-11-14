<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBuildingRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $buildingId = $this->route('building_id') ?? $this->route('building');
        $collegeId = $this->input('college_id');

        return [
            'college_id' => ['required', 'exists:colleges,id'],
            'name' => [
                'required',
                'string',
                'max:300',
                Rule::unique('buildings', 'name')
                    ->where('college_id', $collegeId)
                    ->ignore($buildingId),
            ],
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('buildings', 'code')
                    ->where('college_id', $collegeId)
                    ->ignore($buildingId),
            ],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ];
    }
}
