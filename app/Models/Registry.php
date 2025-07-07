<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Registry extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRouteKeyName(): string
    {
        return 'basic_inn';
    }

    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class);
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }

    public function auditors(): HasMany
    {
        return $this->hasMany(Auditor::class);
    }

    public function auditActivity(): HasMany
    {
        return $this->hasMany(InformationAboutAuditActivity::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Bitrix24CompanyType::class, 'bitrix24_company_type_id');
    }

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class);
    }

    public function plan(): HasOne
    {
        return $this->hasOne(Plan::class);
    }

    public function statuses(): BelongsToMany
    {
        return $this->belongsToMany(Status::class, 'registry_status');
    }

}
