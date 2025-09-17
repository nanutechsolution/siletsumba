<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'show_in_footer',
    ];


    public function scopeFooter($query)
    {
        return $query->where('show_in_footer', true)
            ->where('status', 'published');
    }
}