<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInquiryRequest extends FormRequest
{
    protected $redirectRoute = 'contact';

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
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'min:7', 'max:30', 'regex:/^\+?(?=(?:\D*\d){7,15}\D*$)[0-9()\s-]+$/'],
            'email' => ['nullable', 'email', 'max:254'],
            'service' => ['required', 'string', Rule::in(config('company.services'))],
            'property_type' => ['required', 'in:Home,Business,Farm or remote property,Vehicle,Other'],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
            'website' => ['nullable', 'max:0'],
            'consent' => ['accepted'],
        ];
    }
}
