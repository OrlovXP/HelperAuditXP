<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsTimestamp extends Model
{
    use HasFactory;

    protected $table = 'news_timestamps';

    protected $fillable = ['timestamp'];
}
