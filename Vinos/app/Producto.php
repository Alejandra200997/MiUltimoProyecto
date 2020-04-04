<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //protected $primaryKey="id_producto";
    protected $table = "productos";
    protected $fillable = ['nombre','img','stock','codigo'];
}
