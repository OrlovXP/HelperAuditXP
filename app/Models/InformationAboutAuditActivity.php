<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InformationAboutAuditActivity extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function registry(): BelongsTo
    {
        return $this->belongsTo(Registry::class);
    }
}
