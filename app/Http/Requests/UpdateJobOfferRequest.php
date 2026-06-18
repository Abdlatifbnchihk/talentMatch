<?php

namespace App\Http\Requests;

use App\Enums\JobOfferStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class UpdateJobOfferRequest extends StoreJobOfferRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'status' => ['sometimes', Rule::in(JobOfferStatus::cases())],
        ]);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'required_skills' => array_filter(array_map(
                'trim',
                preg_split('/[,\n]+/', $this->input('required_skills', ''))
            )),
        ]);
    }
}
