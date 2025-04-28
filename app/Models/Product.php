<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'price',
        'quatnity',
        'image',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status' => 'boolean',
    ];
    public function getImageAttribute()
    {
        return getImagePathFromDirectory($this->attributes['image'],'Products');
    }
}
