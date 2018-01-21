<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Page extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['title','content','slug','author_id'];

}
