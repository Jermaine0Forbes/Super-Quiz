<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Subsection;
use App\Result;
use App\SubsectForQuest as SFQ;
use App\QuestCorrect as QC;
class QuestionController extends Controller
{


    public function createQuest(){
      $subsections = Subsection::get();
      return view("create_quest",["title" => "Create", "subsections" => $subsections]);
    }


    public function createQuestAJAX(){
      $subsections = Subsection::get();
      return view("create_quest_ajax",["title" => "AJAX", "subsections" => $subsections]);
    }



    public function deleteQuest($id){
      Question::destroy($id);

      return redirect("questions");
    }

    public function editQuest($id){
      $question = Question::find($id);
      $subsect = Subsection::where("number","like", $question->section."%")->get();
      // dd($subsect);
      $selected = SFQ::where("quest_id",$id)->pluck("subsect_id");
      // $selected =  [];
      // dd($selected);
      return view("edit_quest",["title" => "Edit", "question" => $question, "subsect" => $subsect, "selected" => $selected->toArray()]);
    }

    public function formatAnswers($quest){
      foreach ($quest as $key => $q) {
        $correct = 0;
        $wrong = 0;
        $total = $q->times_on_quiz;
        $correct = $q->correct;
        $q->wrong = $total - $correct;
        // $answers = $q->results()->pluck("correct")->toArray();
        // $answers = $answers ?? false;
        // if ($answers) {
        //   foreach ($answers as $key => $a) {
        //     if($a == 0){
        //       $wrong +=1;
        //     }elseif($a == 1){
        //       $correct +=1;
        //     }
        //   }
        //   $q->correct = $correct;
        //   $q->wrong = $wrong;
        // }

      }

      return $quest;
    }


  



    public function getSubsect(Request $req){
      $section = $req->input("section");
      $subsections = Subsection::where("number","like",$section."%")->get();
      $options = "<option value='' default>n/a</option>";
      foreach ($subsections as $key => $val) {
        $options .= "<option value='".$val->id."' >".$val->number." - ". $val->name." </option>";
      }
      return response()->json(["result" => $options]);
    }

    public function index(){

      $questions = Question::latest()->paginate(10);
      $sections = Question::select("section")->groupBy("section")->get();

      foreach ($questions as $key => $q) {
        $correct = 0;
        $wrong = 0;
        $list = $q->subsections()->pluck("number")->toArray();
        $q->subs = implode(",", $list);
        $answers = $q->results()->pluck("correct")->toArray();
        $answers = $answers ?? false;
        if ($answers) {
          foreach ($answers as $key => $a) {
            if($a == 0){
              $wrong +=1;
            }elseif($a == 1){
              $correct +=1;
            }
          }
          $q->correct = $correct;
          $q->wrong = $wrong;
        }

      }

      return view("list_quest",["title" => "List", "questions" => $questions, "sections" => $sections]);
    }

    public function showQuest($id){
      $question = Question::find($id);
      $results = Result::select("quiz_id","correct")->where("quest_id",$id)->get();
      // dd($results);
      $question->subs = $question->subsections()->get();
      $question->results = empty($results)? 0:$results;

      return view("specific_quest",["question" => $question, "title" => $question->question]);
    }

    public function storeQuest(Request $req){

      $req->validate([
        "question" => "required",
        "section" => "required",
        "subsection" => "required",
        "answer" => "required",
      ]);

        Question::create([
          "question" => $req->input("question"),
          "section" => $req->input("section"),
          "answer" => $req->input("answer"),
        ]);

        $id = Question::latest()->pluck("id")->first();

        foreach ($req->input("subsection") as $key => $sub) {
          SFQ::create([
            "quest_id" => $id,
            "subsect_id" => $sub,
          ]);
        }


        return redirect("questions");
    }

    public function storeQuestAJAX(Request $req){
      $input = $req->all();
      $req->validate([
          "question" => "required",
          "section" => "required",
          "subsection" => "required",
          "answer" => "required",
        ]);

        Question::create([
          "question" => $req->input("question"),
          "section" => $req->input("section"),
          "answer" => $req->input("answer"),
        ]);

        $id = Question::latest()->pluck("id")->first();

        foreach ($req->input("subsection") as $key => $sub) {
          SFQ::create([
            "quest_id" => $id,
            "subsect_id" => $sub,
          ]);
        }

      return response()->json(["data" => $input]);
    }

    public function updateQuest(Request $req,$id){


        Question::where("id", $id)
        ->update([
          "question" => $req->input("question"),
          "section" => $req->input("section"),
          "answer" => $req->input("answer")
        ]);



        $previous = SFQ::where("quest_id", $id)->pluck("subsect_id")->toArray();
        $current = $req->input("subsection");

        foreach ( $current as $key => $sub) {
          SFQ::updateOrCreate([
            "quest_id" => $id,
            "subsect_id" => $sub,
          ]);
        }



        $removed = array_diff($previous,$current);

        if(!empty($previous) && !empty($removed)){

          foreach ($removed as $key => $id) {
            SFQ::where("subsect_id",$id)->delete();
          }
        }



        return redirect("questions");
    }
}
