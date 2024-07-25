<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Door extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function image_front()
    {
        return $this->belongsTo(Image::class, 'image_front_id');
    }

    public function image_back()
    {
        return $this->belongsTo(Image::class, 'image_back_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
