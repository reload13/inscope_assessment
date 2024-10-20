<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;

class EnsureUserBelongsToCompany
{
    public function handle(Request $request, Closure $next)
    {
        $company = $request->route('company');

        if ($request->user()->hasRole(UserRole::Admin) || $request->user()->companies->contains($company->id)) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
