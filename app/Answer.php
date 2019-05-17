<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function question(){
        return $this->belongsTo(Question::class,'question_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'answer_id','id');
    }
}
