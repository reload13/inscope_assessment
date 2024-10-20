<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'company_ids' => ['required', 'array'],
            'company_ids.*' => ['exists:companies,id'],
            'role' => ['required', 'string', new EnumValue(UserRole::class, true)],
        ];
    }
}
