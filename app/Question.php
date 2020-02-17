<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Subsection;
use App\SubsectForQuest;
use App\Result;
class Question extends Model
{
    protected $fillable = ["question","answer","section", "subsection"];

    public static function apiAnswer($id){
      $correct = Result::where("quest_id",$id)->sum("correct");
      $total = Result::where("quest_id",$id)->count();
      $quest = Question::where("id",$id)->pluck("answer");
      $wrong = $total - $correct;
       $meta = "<div class='col-md-6'>
          <p>Total answered questions: <span class='h4 font-weight-bold'>$total</span></p>
          <p>Total correct: <span class='h4 font-weight-bold'>$correct</span></p>
          <p>Total wrong: <span class='h4 font-weight-bold'>$wrong</span></p>
          <a href='/questions/$id'>View details</a>
       </div>";

     return [ "answer" => $quest,
               "correct" => $correct,
               "total" => $total,
               "meta" => $meta,
               "wrong" => $wrong,
             ];
    }



    public function subsections(){
      return $this->belongsToMany("App\Subsection", "subsect_for_quests", "quest_id", "subsect_id");
      // return $this->belongsToMany("App\Subsection", "subsect_for_quests", "quest_id", "subsect_id")->using("App\SubsectForQuest");
    }
    // public function subsections(){
    //   return $this->hasMany("App\Subsection","quest_id");
    // }

    public function results(){
      return $this->hasMany("App\Result","quest_id");
    }
}
