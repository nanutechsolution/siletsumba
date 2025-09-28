<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Article extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'status',
        'scheduled_at',
        'content',
        'excerpt',
        'category_id',
        'is_breaking',
        'location_short',
        'user_id',
        'views',
        'published_by',
        'updated_by',
    ];
    protected $casts = [
        'scheduled_at' => 'datetime',
        'is_breaking' => 'boolean',
    ];
    protected $dates = ['deleted_at'];

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
    public function getIsPublishedAttribute($value)
    {
        if (!is_null($this->status)) {
            return $this->status === 'published';
        }
        return (bool) $value;
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('responsive')
            ->quality(80)
            ->nonQueued()
            ->withResponsiveImages();
        $this->addMediaConversion('thumb')
            ->fit(Fit::Crop, 300, 300)
            ->format('webp')
            ->quality(70)
            ->nonQueued();
    }
    public function registerMediaConversionsdss(?Media $media = null): void
    {
        // Responsive max fit (biar aman portrait/landscape)
        $this->addMediaConversion('400')
            ->fit(Fit::Max, 400, 400)
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


    public function publisher()
    {
        return $this->belongsTo(User::class, 'published_by');
    }
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeTrending($query, $limit = 5)
    {
        return $query->published()
            ->orderBy('views', 'desc')
            ->take($limit);
    }
}
