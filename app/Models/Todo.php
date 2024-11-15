<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status', 'priority', 'user_id'];
    public $timestamps = true; // Ensure timestamps are enabled (default)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
