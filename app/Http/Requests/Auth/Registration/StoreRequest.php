<?php

namespace App\Http\Requests\Auth\Registration;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fio' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email:filter', 'max:100', 'unique:users'],
            'password' => ['required', 'string', Password::defaults()],
        ];
    }
}
