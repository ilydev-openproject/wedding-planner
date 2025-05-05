<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function wedding()
    {
        return $this->belongsTo(Wedding::class, 'wedding_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
