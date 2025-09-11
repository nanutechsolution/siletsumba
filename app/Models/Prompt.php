<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prompt extends Model
{
    protected $fillable = ['name', 'button_text', 'prompt_template', 'description', 'color'];
}
