<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subsection extends Model
{
    protected $fillable = ["name","number"];


    public static function getSubs($quests){
      foreach ($quests as $key => $q) {
        $list = $q->subsections()->pluck("number")->toArray();
        $q->subs = implode(",", $list);
      }
      return $quests;
    }

}
