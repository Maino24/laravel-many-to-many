<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'cover'
    ];

    public function category(){
        //funzione di relazione
        return $this->belongsTo('App\Category'); //Il post ha solo una categoria associata
    }

    public function tags(){
        return $this->belongsToMany('App\Tag');
    }
}
