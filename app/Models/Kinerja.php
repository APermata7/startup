<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kinerja extends Model
{
    use HasFactory;

    protected $table = 'kinerja';
    
    protected $fillable = [
        'penilai_id',
        'dinilai_id',
        'rating',
        'review'
    ];
    
    // Relasi dengan user yang memberikan review
    public function penilai()
    {
        return $this->belongsTo(User::class, 'penilai_id');
    }
    
    // Relasi dengan user yang direview
    public function dinilai()
    {
        return $this->belongsTo(User::class, 'dinilai_id');
    }
}