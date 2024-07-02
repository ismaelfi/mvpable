<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'stripe_plan_id',
        'price',
        'description',
        'features'
    ];

    protected $casts = [
        'features' => 'array',
    ];
}
