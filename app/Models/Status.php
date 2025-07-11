<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Status extends Model
{
    use HasFactory;

    public function registries(): BelongsToMany
    {
        return $this->belongsToMany(Registry::class, 'registry_status');
    }
}
