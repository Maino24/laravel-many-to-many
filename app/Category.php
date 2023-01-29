<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function posts(){
        //funzione di relazione
        return $this->hasMany('App\Posts'); //La categoria ha molti posts associati
    }
}
