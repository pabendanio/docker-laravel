<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // Use HasFactory trait for factory support
    use HasFactory;
    // Define the table associated with the model (optional if it follows Laravel's naming conventions)
    protected $table = 'messages';
    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'name', 
        'email',
        'message',
    ];
}
