<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Door extends Model
{
    use HasFactory;

    protected $fillable = ['name',
        'type',
        'price',
        'is_favorite',
        'image_front_id',
        'image_back_id',
        'brand_id',
        'material_id',
    ];

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

    public function full()
    {
        $res = $this->load('image_front', 'image_back', 'material', 'components');
//        $res = $this->load('brand');
        return $res;
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function components()
    {
        return $this->belongsToMany(Component::class, 'component_doors', 'door_id', 'component_id')
            ->withTimestamps();
    }
}
