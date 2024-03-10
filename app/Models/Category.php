<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    ///de el attributes el ana 3ayzha tt5zn (white list)
    protected $fillable = [
        'name','parent_id','description','image','status','slug'
    ];

    ///de 3ks el fillable y3ny bamn3 el ta5zeen feh (black list) w lw 5lytha fadya m3naha en klo masmo7
    protected $guarded = [];
}
