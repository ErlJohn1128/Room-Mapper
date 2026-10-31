<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Student user to be restricted later
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Core Details
            'name' => 'required|string|max:300|unique:rooms,name',
            'code' => 'required|string|max:30|unique:rooms,code',
            'room_type' => 'required|string|max:300',

            // Foreign Keys
            'floor_id' => 'required|exists:floors,id',
            'custodian_id' =>  'required|exists:custodians,id',

            'is_available' => 'boolean',

            // Specifications
            'equipment' => 'nullable|array',
            'power_outlets' => 'nullable|integer|min:0',
            'fans' => 'nullable|integer|min:0',
            'air_conditioners' => 'nullable|integer|min:0',
            'other' => 'nullable|string'
        ];
    }
}
