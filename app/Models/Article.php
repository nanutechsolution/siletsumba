<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Article extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'image_url',
        'category_id',
        'is_breaking',
        'location_short',
        'user_id',
        'views',
        'is_published',
        'scheduled_at'
    ];
    protected $casts = [
        'scheduled_at' => 'datetime',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ArticleImage::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // public function getImageUrlAttribute()
    // {
    //     $firstImage = $this->images()->first();
    //     return $firstImage
    //         ? asset('storage/' . $firstImage->path)
    //         : 'https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/ef45b1f9-f063-4044-83e2-a9a97cb7c150.png';
    // }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag', 'article_id', 'tag_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getFullContentAttribute()
    {
        $domain = 'siletsumba.com';

        if ($this->location_short) {
            $prefix = "<strong>{$this->location_short}, <span style='color:red;'>{$domain}</span></strong> - ";
        } else {
            $prefix = "<strong><span style='color:red;'>{$domain}</span></strong> - ";
        }

        // masukkan prefix ke dalam <p> pertama jika ada
        if (str_starts_with($this->content, '<p>')) {
            return preg_replace('/^<p>/', "<p>{$prefix}", $this->content, 1);
        }

        // jika tidak ada <p>, tambahkan prefix di depan
        return $prefix . $this->content;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->nonQueued()
            ->format('webp')
            ->withResponsiveImages();

        $this->addMediaConversion('thumb')
            ->fit(Fit::Crop, 300, 300)
            ->format('webp')
            ->quality(80)
            ->nonQueued();
    }

    public function registerMediaConversionsssss(Media $media = null): void
    {
        // Responsive max fit (biar aman portrait/landscape)
        $this->addMediaConversion('400')
            ->fit(Fit::Max, 400, 400) // <= rasio tetap aman
            ->format('webp')
            ->quality(80)
            ->nonQueued();

        $this->addMediaConversion('800')
            ->fit(Fit::Max, 800, 800)
            ->format('webp')
            ->quality(80)
            ->nonQueued();

        $this->addMediaConversion('1200')
            ->fit(Fit::Max, 1200, 1200)
            ->format('webp')
            ->quality(80)
            ->nonQueued();

        // Thumbnail square (khusus, opsional)
        $this->addMediaConversion('thumb')
            ->fit(Fit::Crop, 300, 300)
            ->format('webp')
            ->quality(70)
            ->nonQueued();
    }
}
