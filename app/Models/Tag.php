<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name', 'slug'
    ];


    //for relation many to many
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
