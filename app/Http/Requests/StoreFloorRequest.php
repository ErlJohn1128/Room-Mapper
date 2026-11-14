<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFloorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

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
