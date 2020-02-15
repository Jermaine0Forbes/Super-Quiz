<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Subsection;
use App\Result;
use App\SubsectForQuest as SFQ;
use App\QuestCorrect as QC;

class QuestionAPIController extends Controller
{
  public function getAJAX($id){
    // $quest = Question::where("id",$id)->pluck("answer");
    // $quest = Question::where("id",$id)->get();
    // $data = $this->formatAnswer($id);
    $data = Question::apiAnswer($id);
    // $quest->push(["test" => "this is a test"]);
    // $quest = $quest->getTest($quest);
    // $html = "
    //   <div> Correct: $quest->correct | Wrong: $quest->wrong </div>
    //   <p>$quest->answer</p>
    // ";
    return response()->json($data);
  }

  public function queryQuest(Request $req){

    if($req->ajax()){

      $query =  $req->input("query");

      if( $query != ""){

        $data = Question::select("question")->where("question","like", "%".$query."%")->get();

      }else{
        $data = Question::select("question")->get();
      }

      return response()->json(["data" => $data]);
    }

  }
}
