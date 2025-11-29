<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'instagram',
        'branch',
        'revenue_raw',
        'revenue_category',
        'investment_raw',
        'investment_category',
        'objective',
        'has_traffic',
        'ai_tags',
        'score',
        'urgency',
        'kanban_status',
    ];

    protected $casts = [
        'ai_tags' => 'array',
    ];
}
