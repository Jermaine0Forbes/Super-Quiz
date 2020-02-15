@extends('layouts.question_layout')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
          <h2 class="text-center">{{$question->question}}</h2>
          <div class="nav bg-primary mb-4">
              <a href="/question/edit/{{$question->id}}" class="text-white nav-link">Edit</a>
              <a href="/question/delete/{{$question->id}}" id="btn-delete" class="text-white nav-link">Delete</a>
              {{-- <a  id="btn-delete" class="text-white nav-link">Delete</a> --}}
          </div>

          <ul class="list-group list-group-flush">
          <li class="list-group-item">Section: {{$question->section}}</li>
          <li class="list-group-item">Subsection:
            <ul>
              @foreach ($question->subs as $key => $subs)
                <li>{{$subs->name}} - {{$subs->number}}</li>
              @endforeach
            </ul>

          </li>
          <li class="list-group-item">Code:
            <code>{{$question->answer}}</code>
          </li>
          <li class="list-group-item">Answer:
            @php
              echo html_entity_decode($question->answer);
            @endphp
          </li>
          <li class="list-group-item">Quiz:
            @if (count($question->results) > 0)
              @foreach ($question->results as $key => $result)
                @if ($result->correct == 1)
                  <p><span class="fa fa-check text-success"></span> from <strong> quiz #{{$result->quiz_id}} </strong></p>
                @elseif ($result->correct == 0)
                  <p><span class="fa fa-times text-danger"></span> from <strong> quiz #{{$result->quiz_id}} </strong></p>
                @else
                  <p>? from <strong> quiz #{{$result->quiz_id}} </strong></p>
                @endif

              @endforeach
            @else
              You have no results for this question
            @endif
          </li>

          </ul>
      </div>
    </div>
    <script>
      (function(){

        console.log("foo")
      })()

    </script>
  </div>



@stop
