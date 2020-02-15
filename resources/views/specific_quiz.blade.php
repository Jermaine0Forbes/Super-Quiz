@extends('layouts.quiz_layout')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
          <h1 class="text-center">Quiz #{{$id}}</h1>
          <h3>{{$date}} , {{$count}} Questions</h3>

            @foreach ($quiz as $key => $q)
                <div class="question-item" data-id="{{$q->quest_id}}">
              @if ($q->correct)
                <button  class="dropdown-btn list-group-item bg-success text-white w-100 d-flex justify-content-between" type="button" name="button">
                  <span class="fas fa-check"></span>  {{$q->name}}  <span class="dropdown-btn fas chevron fa-chevron-down text-right"></span>
                </button>
              @else
                <button class="dropdown-btn list-group-item bg-danger text-white w-100 d-flex justify-content-between" type="button" name="button">
                  <span class="fas fa-times "></span>  {{$q->name}} <span class=" dropdown-btn fas chevron fa-chevron-down text-right"></span>
                </button>
              @endif
                <div class="question-container" style="display:none;">
                  <p class="load-it">
                  </p>
                  <div class="loader text-center">
                    <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                  </div>


                  <div class="content">
                    <div class="row justify-content-center">
                      <div class="answer-info col-md-8 d-flex align-items-center" >
                        <div class="chart" >
                          <canvas id="chart-{{$q->quest_id}}" width="300" height="300"></canvas>
                        </div>

                      </div>

                    </div>

                    <h3 class="border-bottom">Answer</h3>
                    <div class="answer">

                    </div>
                  </div>
                </div>
              </div>
            @endforeach

          {{-- <ul class="list-group list-group-flush">
              @foreach ($quiz as $key => $q)
                @if ($q->correct)
                  <li class="list-group-item bg-success text-white"><span class="fas fa-check"> </span>  {{$q->name}}  <span class="fas fa-chevron-down text-right"></span></li>
                @else
                  <li class="list-group-item bg-danger text-white"><span class="fas fa-times "> </span>  {{$q->name}} <span class="fas fa-chevron-down text-right"></span></li>
                @endif

              @endforeach
          </ul> --}}
      </div>
    </div>
  </div

@stop
