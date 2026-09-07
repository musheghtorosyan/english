<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Word extends Model
{
    protected $fillable = [
        'word',
        'translation_hy',
        'translation_ru',
        'level',
        'part_of_speech',
        'frequency_rank',
    ];

    public function learners(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('learned_at')
            ->withTimestamps();
    }

    public function translationFor(?User $user): ?string
    {
        if ($user?->preferred_translation === 'ru') {
            return $this->translation_ru ?: $this->translation_hy;
        }

        return $this->translation_hy ?: $this->translation_ru;
    }
}
