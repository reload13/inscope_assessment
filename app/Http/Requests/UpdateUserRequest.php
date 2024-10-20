<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $this->route('user')->id],
            'company_ids' => ['nullable', 'array'],
            'company_ids.*' => ['exists:companies,id'],
            'role' => ['required', 'string', new EnumValue(UserRole::class, true)],
            'password' => ['nullable', 'string', 'min:8'],
        ];
    }
}
