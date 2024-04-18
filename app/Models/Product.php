<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    ///Global Scope (Authorization)
    protected static function booted()
    {
        static::addGlobalScope('store',new StoreScope());
    }

    //Relation one to many
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    //Relation one to many
    public function store()
    {
        return $this->belongsTo(Store::class,'store_id','id');
    }

    //for relation many to many
    public function tags()
    {
        return $this->belongsToMany(Tag::class,'product_tag','product_id','tag_id','id','id');
        //Related Model, Pivot Table, FK in pivot table for the current model, FK in pivot table for the related model, PK curr model, PK related Model
    }
}
