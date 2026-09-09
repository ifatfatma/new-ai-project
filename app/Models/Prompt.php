<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prompt extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'label',
        'prompt_text',
    ];

    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}