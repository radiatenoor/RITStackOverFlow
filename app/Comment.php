<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function answer(){
        return $this->belongsTo(Answer::class,'answer_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
