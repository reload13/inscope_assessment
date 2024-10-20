<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Project extends Model
{
    use HasFactory, HasUlids, RefreshDatabase;
    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function scopeBelongsToCompany($query, $companyId)
    {
        return $query->whereHas('companies', function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        });
    }
}
