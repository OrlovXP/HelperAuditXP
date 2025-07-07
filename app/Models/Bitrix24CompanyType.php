<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bitrix24CompanyType extends Model
{
    use HasFactory;

    protected $table = 'bitrix24_company_type';

    protected $guarded = [];

    public function registry(): BelongsTo
    {
        return $this->belongsTo(Registry::class);
    }
}
