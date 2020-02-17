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

  public function formatSubs($quests){
    foreach ($quests as $key => $q) {
      $list = $q->subsections()->pluck("number")->toArray();
      $q->subs = implode(",", $list);
    }
    return $quests;
  }


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

  public function getFilter(Request $req){
    $filter = $req->input("filter");
    $section = $req->input("section") ;
    $data = "";

    // if ($filter =="recent") {
    //   $quests = Question::where("section",$section)->latest()->get();
    // }else{
    //   $quests = $section > 0 ?  Question::where("section",$section)->get(): Question::get();
    // }

    switch ($filter) {
      case 'recent':
          $quests = $section > 0 ?  QC::where("section",$section)->latest()->get(): QC::latest()->get();
        break;
      case 'incorrect':
          $quests = ($section > 0)?  QC::where("section",$section)->orderBy("wrong","desc")->get() : QC::orderBy("wrong","desc")->get();
        break;
      case 'correct':
        $quests = $section > 0 ?  QC::where("section",$section)->orderBy("correct","desc")->get() : QC::orderBy("correct","desc")->get();
        break;

      default:
          $quests = $section > 0 ?  QC::where("section",$section)->get(): QC::get();
        break;
    }
    // if ($filter =="recent") {
    //   $quests = QC::where("section",$section)->latest()->get();
    // }else{
    //   $quests = $section > 0 ?  QC::where("section",$section)->get(): QC::get();
    // }

    // $quests = $this->formatAnswers($quests);
    $quests = Subsection::getSubs($quests);

    foreach ($quests as $key => $q) {

      $correct = empty($q->correct)? "N/A" :"<span class='badge badge-success'>$q->correct </span>" ;
      $wrong = empty($q->wrong )? "N/A" :"<span class='badge badge-danger'>$q->wrong </span>";
      $subs = empty($q->subs) ? "N/A" :$q->subs ;
      $link = "";
      $data .="
      <div class=\"mb-4 py-3 border-bottom\">
        <div class=\"row\">
          <div class=\"col-md-8\">
            <h4><a href=\"/questions/{$q->id} \">{$q->question}</a></h4>
            <h6>Section:{$q->section}, Subsection: $subs,
              Correct: $correct , Wrong: $wrong</h6>
          </div>
          <div class=\"col-md-4 ml-auto\">
            <ul class=\"nav d-flex justify-content-end\">
              <li class=\"nav-item\"><a href=\"/question/edit/{$q->id}\" class=\"px-1\">Edit</a>|</li>
              <li class=\"nav-item\"><a href=\"/questions/{$q->id}\" class=\"px-1\">Details</a>|</li>
              <li class=\"nav-item\"><a href=\"/question/delete/{$q->id}\" class=\"px-1\">Remove</a></li>
            </ul>
          </div>
        </div>
      </div>
      ";
    }

    return response()->json(["data" => $data]);
  }


  public function queryQuest(Request $req){

    if($req->ajax()){
      $quest = new QC;
      $quest = $quest->newQuery();
      $quests = "";
      $query =  $req->input("query");
      $filter =  $req->input("filter");
      $section =  $req->input("section");
      $quest->select(["id", "question", "section","wrong", "correct"]);

        if(!empty($query)){

          $quest->where("question","like", "%".$query."%");
        }

        if(!empty($section)){
          $quest->where("section",$section);
        }

        switch ($filter) {
          case 'recent':
              $quest->latest();
            break;
          case 'incorrect':
              $quest->orderBy("wrong","desc");
            break;
          case 'correct':
            $quest->orderBy("correct","desc");
            break;
        }


        $data = $quest->get();

        $data = Subsection::getSubs($data);

        foreach ($data as $key => $q) {

          $correct = empty($q->correct)? "N/A" :"<span class='badge badge-success'>$q->correct </span>" ;
          $wrong = empty($q->wrong )? "N/A" :"<span class='badge badge-danger'>$q->wrong </span>";
          $subs = empty($q->subs) ? "N/A" :$q->subs ;
          $link = "";
          $quests .="
          <div class=\"mb-4 py-3 border-bottom\">
            <div class=\"row\">
              <div class=\"col-md-8\">
                <h4><a href=\"/questions/{$q->id} \">{$q->question}</a></h4>
                <h6>Section:{$q->section}, Subsection: $subs,
                  Correct: $correct , Wrong: $wrong</h6>
              </div>
              <div class=\"col-md-4 ml-auto\">
                <ul class=\"nav d-flex justify-content-end\">
                  <li class=\"nav-item\"><a href=\"/question/edit/{$q->id}\" class=\"px-1\">Edit</a>|</li>
                  <li class=\"nav-item\"><a href=\"/questions/{$q->id}\" class=\"px-1\">Details</a>|</li>
                  <li class=\"nav-item\"><a href=\"/question/delete/{$q->id}\" class=\"px-1\">Remove</a></li>
                </ul>
              </div>
            </div>
          </div>
          ";
        }

        if(empty($quests)){
          $quests = "<h2 class='text-muted text-center'>We found no questions</h2>";
        }
      // return response()->json($req->all());
      return response()->json(["data" => $quests]);
      // return response()->json(["data" => $filter]);
    }

    return response()->json(["data" => "no data found"]);

  }
}
