<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'color'
    ];

    public function colorVariant()
    {
        return $this->hasMany(ProductVariant::class, 'color_id');
    }

    public function SizeVariant()
    {
        return $this->hasMany(ProductVariant::class, 'size_id');
    }
}
