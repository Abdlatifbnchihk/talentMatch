<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreJobOfferRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string'],
            'required_skills' => ['required', 'min:1'],
            'required_skills.*' => ['string'],
            'min_experience_years' => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (is_string($this->required_skills)) {
                $this->merge([
                    'required_skills' => array_filter(array_map('trim', explode(',', $this->required_skills))),
                ]);
            }
        });
    }
}