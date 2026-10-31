<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFloorRequest extends FormRequest
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
            'building_id' => 'required|exists:buildings,id',
            'name' => [
                'required','string','max:300',
                Rule::unique('floors', 'name')
                    ->where('building_id', $this->building_id)
            ],
            'code' => [
                'required','string','max:50',
                Rule::unique('floors', 'code')
                    ->where('building_id', $this->building_id)
            ]
        ];  
    }
}
