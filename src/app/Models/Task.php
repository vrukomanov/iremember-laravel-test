<?php

namespace App\Models;

use App\Enum\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'status'
    ];

    protected $casts = [
        'status' => TaskStatus::class
    ];
}
