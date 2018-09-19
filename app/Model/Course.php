<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
   protected $guarded=[];

   public function tag(){
       return $this->belongsTo(Tag::class,'tag_id','id');
   }
}
