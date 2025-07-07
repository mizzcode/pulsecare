<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $table = 'recommendations';

    protected $fillable = ['level', 'title', 'description'];

    public function scopeByLevel($query, $level)
    {
        return $query->where('level', strtolower($level));
    }
}