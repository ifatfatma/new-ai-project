<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'raw_meta_tags', // <--- Yeh yahan add karna zaroori hai
        'meta_description',
        'meta_keywords',
        'tools',
        'og_image',
    ];

    protected $casts = [
        'tools' => 'array',
    ];
}