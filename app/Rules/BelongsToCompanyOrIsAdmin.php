<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\User;
use Closure;

class BelongsToCompanyOrIsAdmin implements ValidationRule
{
    protected $companyId;

    public function __construct($companyId)
    {
        $this->companyId = $companyId;
    }

    /**
     * Validate if the creator has the appropriate role and belongs to the company.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $creator = User::find($value);

        if (!$creator) {
            $fail('The :attribute doest exist.');
        }

        if($creator->hasRole('moderator') && ! $creator->companies->contains($this->companyId)){
            $fail('The :attribute doest exist.');
        }
    }

    /**
     * Error message to return if validation fails.
     */
    public function message()
    {
        return 'The selected creator must either be an admin or a moderator belonging to the specified company.';
    }
}
