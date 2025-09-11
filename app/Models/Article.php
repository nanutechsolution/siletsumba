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
        'user_id',
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
        return $this->belongsToMany(Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedContentAttribute()
    {
        $domain = '<strong class="text-red-600">siletsumba.com</strong>';
        $content = $this->content;

        // Cari paragraf pertama
        if (preg_match('#<p>(.*?)</p>#s', $content, $matches)) {
            $firstParagraph = $matches[1];

            // Case: pembuka dengan <strong>LOKASI</strong> -
            if (preg_match('#^<strong.*?>(.*?)</strong>\s*-\s*#', $firstParagraph, $loc)) {
                $replace = '<strong style="font-size: 13px;">' . $loc[1] . '</strong>, ' . $domain . ' - ';
                $newFirstParagraph = preg_replace(
                    '#^<strong.*?>(.*?)</strong>\s*-\s*#',
                    $replace,
                    $firstParagraph
                );

                // Ganti hanya paragraf pertama
                $content = preg_replace('#<p>.*?</p>#s', '<p>' . $newFirstParagraph . '</p>', $content, 1);
            }
        }

        return $content;
    }
}
