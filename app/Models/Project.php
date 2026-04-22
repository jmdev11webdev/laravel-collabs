<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'title', 
    'description', 
    'link', 
    'repository', 
    'starter_kit', 
    'status', 
    'is_public', 
    'deadline', 
    'max_collaborators', 
    'contact_email'])]

class Project extends Model
{
    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
            'deadline' => 'date',
            'max_collaborators' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
