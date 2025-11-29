<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_text',
        'field_name',
        'input_type',
        'options',
        'placeholder',
        'order',
        'is_active',
        'is_required',
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
        'is_required' => 'boolean',
    ];
}
