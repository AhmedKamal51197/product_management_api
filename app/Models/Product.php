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
        'quantity',
        'image',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status' => 'boolean',
    ];
    protected $hidden = [
        'deleted_at',
    ];
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = ($value =='active') ? 1 : 0;
    }
    public function getStatusAttribute()
    {
        return $this->attributes['status'] == 1 ? 'active' : 'inactive';
    }
}
