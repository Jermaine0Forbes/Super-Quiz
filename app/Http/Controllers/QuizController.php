<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection ;
use App\Question;
use App\Quiz;
use App\Result;
class QuizController extends Controller
{
    public function index(){
      $quizzes  = Quiz::select("id", "no_completed", "no_correct")->latest()->get();
      foreach ($quizzes as $key => $q) {
        $wrong = $q->no_completed - $q->no_correct;
        $q->wrong = $wrong;
        $q->score = ($q->no_correct / $q->no_completed) * 100;
        $q->score = is_float($q->score)? round($q->score, 1): $q->score ;
        switch (true) {
          case $q->score >= 90:
           $q->emote = "&#129321;";
            break;

          case $q->score >= 80:
           $q->emote = "&#129303;";
            break;
          case $q->score >= 70:
           $q->emote = "&#129320;";
            break;

          default:
          $q->emote = "&#128577;";
        }

      }
      return view("index", ["quizzes" => $quizzes]);
    }

    public function preQuiz(){
      // $questions = Question::limit(5)->get();
       $questions = Question::get()->random(10);
       $sections = Question::select("section")->groupBy("section")->get();

      // $questions = Question::get();
      // $c = collect($questions);
      // $sh = $c->shuffle();
      // dd($q);

      foreach ($questions as $key => $q) {
        $list = $q->subsections()->pluck("name")->toArray();
        $q->subs = implode(",", $list);
      }

      return view("quiz",["title" => "Start", "questions" => $questions, "sections" => $sections]);
    }


    public function showQuiz($id){
      $quizzes = Result::where("quiz_id",$id)->get();
      $quiz = Quiz::where("id",$id)->get()->first();
      $count = $quiz->no_completed;
      $date = $quiz->created_at->toFormattedDateString("mmmm dddd Y");
      // dd($date->created_at->toFormattedDateString("MMMM dddd Y"));
      foreach ($quizzes as $key => $q) {
         $quest_id = $q->quest_id;
         $quest = Question::select("question","answer")->where("id",$quest_id)->get()->first();
         $q->name = $quest->question;
      }

      return view("specific_quiz",["title" => "Quiz $id", "quiz" => $quizzes, "count" => $count,"date" =>$date, "id" => $id]);
    }

    public function startQuiz(Request $req){

      $section = intval($req->input("section"));
      $timed = $req->input("timed");
      $number = $req->input("number");
      $total = $number;
      $quests = [];
      $i = 1;

      if($section){
          $count  = Question::where("section",$section)->count();
          $n = $number > $count ? $count: $number;
         $questions = Question::where("section",$section)->get()->random($n);

      }else{
        $count  = Question::count();
        $n = $number > $count ? $count: $number;
        $questions = Question::get()->random($n);
      }

      while( $number > 0 ){
        $number -= $count;
        $number = $number >= 0 ? $number: 0;
        $n = $number >= $n ? $n: $number;

        if($number){
          // $questions->add(Question::where("section",3)->get()->random($n)) ;
          $quest = $section > 0 ? Question::where("section",$section)->get()->random($n) : Question::get()->random($n);
          foreach ( $quest as $key => $q) {
            $questions->add($q);
          }
        }

      }

      foreach ($questions as $key => $q) {
        $list = $q->subsections()->pluck("name")->toArray();
        $q->subs = implode(",", $list);
      }

      foreach ($questions as $key => $q) {

        $style = $i > 1 ? "position:absolute; display:none" : "position:absolute;";
        $quests[] = "
        <div class=\"question-block my-5  w-100\" style=\" $style \">
          <div class='border-bottom text-right'>
            <h5>Question {$i}/{$total}</h5>
          </div>
          <div class='border-bottom'>
            <h2 class=\"question-name \" data-id=\"$q->id \"> $q->question</h2>
          </div>
          <div class=\"border-bottom \">
            <h4>Section: {$q->section}</h4>
          </div>
          <div class=\"border-bottom \">
            <h4>Subsection: {$q->subs}</h4>
          </div>
          <div class=\"d-flex justify-content-between \">
            <h3>Answer:</h3>
            <a  style= \"height:25px;width:25px;text-align:center;margin-top:0.5em; \" class=\"bg-primary text-white rounded-circle btn-answer \" > <span class= \"fa fa-plus \"></span> </a>
          </div>
          <div class=\"answer-container \">
            {$q->answer}
          </div>
          <div class= \"mt-5 \">
            <button type=\"button \" name=\"button \" class= \"btn btn-primary btn-result \" data-result=\"1 \"><span class=\"fa fa-check \"></span> Correct</button>
            <button type=\"button \" name=\"button \" class=\"btn btn-danger btn-result \" data-result=\"0 \"><span class=\"fa fa-times \"></span> Wrong</button>
          </div>
        </div>";
        $i++;
      }



      return response()->json(["data" => $quests]);
    }



    public function storeQuiz(Request $req){


      Quiz::create([
        "type" => $req->input("type"),
        "timed" => $req->input("timed"),
        "minutes" => $req->input("minutes"),
        "no_completed" => $req->input("completed"),
        "no_correct" => $req->input("correct"),
        "quiz_results" => $req->input("questions"),
      ]);

       $quiz = Quiz::select("id")->latest()->first();
       $ids = $req->input("ids");
       $correct = $req->input("answers");


       for ($i=0; $i < count($ids); $i++) {
         Result::create([
           "quiz_id" => $quiz->id,
            "quest_id" => $ids[$i],
            "correct" => $correct[$i]
         ]);
       }

       // foreach ($ids as $key => $id) {
       //   Result::create([
       //     "quiz_id" => $quiz->id,
       //      "quest_id" => $id,
       //      "correct" =>
       //   ]);
       // }

        $total = $req->input("completed");
        $correct = $req->input("correct");
       $score = ($correct / $total) * 100;
       $score = is_float($score)? round($score, 1): $score ;
       $c = "";

       switch (true) {
         case $score >= 90:
          $emote = "&#129321;";
          $c = "text-success";
           break;

         case $score >= 80:
          $emote = "&#129303;";
            $c = "text-success";
           break;
         case $score >= 70:
          $emote = "&#129320;";
           break;

         default:
             $emote = "&#128577;";
           break;
       }

       $success = "
       <h2 class=$c >$emote $score% </h2>
       <h3> You have gotten ".$req->input("correct")." out of ".$req->input("completed")."  correct </h3>
       <a href='/quiz' class='btn btn-primary btn-lg'>Restart Quiz</a>
       ";

      return response()
                ->json(['success' => $success]);
    }
}
