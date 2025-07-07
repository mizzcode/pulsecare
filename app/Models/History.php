<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';

    protected $fillable = [
        'score',
        'level',
        'assesment_result_id',
    ];

    public function assesmentResult()
    {
        return $this->belongsTo(AssesmentResult::class, 'assesment_result_id');
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class, 'level', 'level');
    }

    // Method untuk mengambil rekomendasi berdasarkan level
    public function getRecommendations()
    {
        return Recommendation::byLevel($this->level)->get();
    }
}
