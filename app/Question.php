<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /*many To many RelationShip*/
    public function tags(){
        return $this->belongsToMany(Tag::class,'question_tags','question_id','tag_id')
            ->withTimestamps();
    }

    /*One To many RelationShip*/
    public function category(){
        return $this->belongsTo('App\Category','category_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function answers(){
        return $this->hasMany(Answer::class,'question_id','id');
    }
}
