<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FrontendUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'frontend_users';

    protected $fillable = [
        'name',
        'email',
        'profile_image',
    ];

    protected $hidden = [
        'remember_token',
    ];

    /**
     * Frontend user's saved prompts.
     */
    public function savedPrompts(): BelongsToMany
    {
        return $this->belongsToMany(
            Prompt::class,
            'saved_prompts',
            'frontend_user_id',
            'prompt_id'
        )->withTimestamps();
    }

    /**
     * Prompts created by this frontend user.
     */
    public function prompts()
    {
        return $this->hasMany(Prompt::class, 'frontend_user_id');
    }
}