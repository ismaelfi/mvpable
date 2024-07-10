<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name', 'site_description', 'support_email', 'support_phone',
        'google_analytics_id', 'html_snippet', 'seo_title', 'seo_keywords',
        'seo_metadata', 'favicon', 'logo',
    ];

    protected $casts = [
        'seo_metadata' => 'array',
    ];
}
