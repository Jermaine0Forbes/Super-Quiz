@extends('layouts.default')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <h2>Welcome to CDL Study</h2>
        <div class="quiz-container">
          @foreach ($quizzes as $key => $q)
            <div class="mb-4 py-3 border-bottom">
              <div class="row">
                <div class="col-md-8">
                  <h4><a href="/quiz/index/{{$q->id}} ">Quiz #{{$q->id}}</a></h4>
                  <h6> <span>@php
                   echo  $q->emote;
                  @endphp {{$q->score}}%</span> <span class=text-muted >|</span> <span class="text-success fas fa-check"></span>  Correct: {{$q->no_correct}},  <span class="text-danger fas fa-times"></span> Wrong: {{$q->wrong}}</h6>
                </div>
                </div>
              </div>

          @endforeach
          </div>
        </div>

      </div>
    </div>
  </div>

@stop
