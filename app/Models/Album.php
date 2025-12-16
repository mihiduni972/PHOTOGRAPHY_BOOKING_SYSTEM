<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cover_image', 
        'category_id',
        'slug',
        'price',     
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($album) {
            $album->slug = Str::slug($album->name);
        });
        static::updating(function ($album) {
            if ($album->isDirty('name')) {
                $album->slug = Str::slug($album->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function photos()
    {
        return $this->hasMany(AlbumPhoto::class); 
    }
}