<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'preferred_translation', 'daily_goal', 'streak_days', 'last_study_date'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_study_date' => 'date',
            'daily_goal' => 'integer',
            'streak_days' => 'integer',
        ];
    }

    public function words(): BelongsToMany
    {
        return $this->belongsToMany(Word::class)
            ->withPivot('learned_at')
            ->withTimestamps();
    }

    public function phrases(): BelongsToMany
    {
        return $this->belongsToMany(Phrase::class, 'user_phrase')
            ->withPivot('learned_at')
            ->withTimestamps();
    }

    public function recordStudyDay(): void
    {
        $today = now()->toDateString();

        if ($this->last_study_date?->toDateString() === $today) {
            return;
        }

        $yesterday = now()->subDay()->toDateString();
        $this->streak_days = $this->last_study_date?->toDateString() === $yesterday
            ? $this->streak_days + 1
            : 1;
        $this->last_study_date = $today;
        $this->save();
    }

    public function translationLabel(): string
    {
        return $this->preferred_translation === 'ru' ? 'Русский' : 'Հայերեն';
    }
}
