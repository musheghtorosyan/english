<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Phrase extends Model
{
    protected $fillable = [
        'phrase',
        'translation_hy',
        'translation_ru',
        'category',
        'level',
        'example_en',
    ];

    public function learners(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_phrase')
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

    public function categoryLabel(): string
    {
        return match ($this->category) {
            'phrasal_verb' => 'Phrasal verb',
            'collocation' => 'Collocation',
            default => 'Idiom',
        };
    }
}
