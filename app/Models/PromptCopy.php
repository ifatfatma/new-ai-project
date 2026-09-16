<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromptCopy extends Model
{
    protected $fillable = ['prompt_id', 'copied_date'];

    public function prompt()
    {
        return $this->belongsTo(Prompt::class);
    }
}