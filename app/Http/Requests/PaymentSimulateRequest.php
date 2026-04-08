<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ApiResponse;

class PaymentSimulateRequest extends FormRequest
{
    use ApiResponse;
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
        return [
            'amount' => 'required|numeric|min:0.01',
            'card_number' => 'required|digits:16',
            'expiry_month' => 'required|digits:2|between:01,12',
            'expiry_year' => 'required|digits:4|after_or_equal:' . date('Y'),
            'cvv' => 'required|digits:3',
            'currency' => 'required|in:USD,AED,EGP'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->errorResponse('Validation Error', $validator->errors(), 422)
        );
    }
}
