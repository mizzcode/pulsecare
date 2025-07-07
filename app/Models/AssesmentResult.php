<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssesmentResult extends Model
{
    protected $table = 'assesment_results';

    protected $fillable = [
        'depression_score',
        'depression_level',
        'anxiety_score',
        'anxiety_level',
        'stress_score',
        'stress_level',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function history()
    {
        return $this->hasOne(History::class, 'assesment_result_id');
    }
}
