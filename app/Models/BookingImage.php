<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'file_path',
        'file_name',
    ];

    /**
     * Get the category that owns the BookingImage.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}