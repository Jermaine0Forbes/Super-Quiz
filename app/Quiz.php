<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
  protected $fillable = ["type","timed","minutes", "no_completed","no_correct","quiz_results"];
  protected $dates = ["created_at"];


}
