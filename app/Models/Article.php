<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'category_id',
        'is_breaking',
        'location_short',
        'user_id',
        'views',
        'is_published',
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

    public function getImageUrlAttribute()
    {
        $firstImage = $this->images()->first();
        return $firstImage
            ? asset('storage/' . $firstImage->path) // sesuaikan field 'path' di ArticleImage
            : 'https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/ef45b1f9-f063-4044-83e2-a9a97cb7c150.png';
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
}