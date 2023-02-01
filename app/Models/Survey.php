<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory, HasSlug;

    const TYPE_TEXT = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_SELECT = 'select';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_RADIO = 'radio';

    protected $fillable = [
        'user_id', 'title', 'slug', 'image', 'status', 'description', 'expire_date'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug');
    }
    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class);
    }
    public function answers()
    {
        return $this->hasMany(SurveyAnswer::class);
    }
}
