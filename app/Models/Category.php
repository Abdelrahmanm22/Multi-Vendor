<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    ///de el attributes el ana 3ayzha tt5zn (white list)
    protected $fillable = [
        'name','parent_id','description','image','status','slug'
    ];

    ///Eloquent Model Local scopes
    public function scopeActive(Builder $builder)
    {
        $builder->where('status','=','active');
    }

    public function scopeStatus(Builder $builder,$status)
    {
        $builder->where('status','=',$status);
    }
    public function scopeFilter(Builder $builder,$filters)
    {
        if ($filters['name']?? false){
            $builder->where('name','LIKE',"%{$filters['name']}%");
        }
        if ($filters['status']?? false){
            $builder->where('categories.status','=',$filters['status']);
        }
    }

    ///de 3ks el fillable y3ny bamn3 el ta5zeen feh (black list) w lw 5lytha fadya m3naha en klo masmo7
    protected $guarded = [];
}
