<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
  public function get(){
    $id = 104;
    $correct = Result::where("quest_id",$id)->sum("correct");
    $total = Result::select("correct")->where("quest_id",$id)->count();
    $quest = Question::where("id",$id)->pluck("answer");
    $wrong = $total - $correct;
   $result = [ "answer" => $quest[0],
             "correct" => $correct,
             "total" => $total,
             "wrong" => $wrong,
           ];

      dd($result);

    // $q = Question::find(25)->subsections()->get();
    // $q = Question::where("section",2)->get();
    // $quests = $this->formatAnswers($q);

    // $qc = QC::limit(5)->get();
    //
    // dd($qc);


    // $count = Question::where("section",3)->count();
    // $number = 45;
    // $n =  $number > $count ? $count: $number;
    // $questions = Question::where("section",3)->get()->random($n);
    // // $questions = Question::where("section",3)->get()->random($n)->toArray();
    // while( $number > 0 ){
    //   $number -= $count;
    //   $number = $number >= 0 ? $number: 0;
    //   $n = $number >= $n ? $n: $number;
    //
    //   if($number){
    //     // $questions->add(Question::where("section",3)->get()->random($n)) ;
    //     // $q = $questions->merge(Question::where("section",3)->get()->random($n));
    //     $quest = Question::where("section",3)->get()->random($n);
    //     foreach ( $quest as $key => $q) {
    //       $questions->add($q);
    //     }
    //   }
    //
    // }
    //
    // // dd($questions);
    // dd($questions);
    // dd($q->all());
    // $q = Question::latest()->pluck("id")->first();

    // return $q;
  }
}
