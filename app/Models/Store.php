<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

//    protected $table = 'stores';
//    protected $connection ='mysql';
//    protected $primaryKey ='id';
//    public $incrementing = false;
//    public $timestamps = false; // لما تشيلهم من الdatabase
//    const CREATED_AT = 'created_at';
//    const UPDATED_AT = 'updated_at'; //lw 7abet a8yar esmohom

    public function products()
    {
        return $this->hasMany(Product::class,'store_id','id');
    }
}
