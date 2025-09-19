<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use  HasFactory, Notifiable, InteractsWithMedia;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'bio',
        'slug',
        'profile_photo_path',
        'is_active',
        'social_links',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'social_links' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Check roles
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    public function isWriter(): bool
    {
        return $this->role === 'writer';
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('small')
            ->nonQueued()
            ->fit(Fit::Crop, 48, 48)
            ->format('webp')
            ->quality(80);

        $this->addMediaConversion('small')
            ->nonQueued()
            ->fit(Fit::Crop, 48, 48)
            ->format('webp')
            ->quality(80)
            ->nonQueued();
    }
}