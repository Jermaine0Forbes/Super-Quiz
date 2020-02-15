@extends('layouts.question_layout')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
          <h1 class="mb-4">Questions</h1>
          <div class="d-flex border-bottom pb-2">
            <div class="mr-5">
              <form class=""  method="post">
                <div class="input-group">
                  <input class="px-2" type="search" name="search" placeholder="Search for questions">
                  <div class="input-group-append">
                    <button id="ajax-search-btn"class="btn btn-outline-secondary" type="button" name="button">Search</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="mr-5">
              <span>Filter: </span>
              <select class="" name="filter">
                <option value="recent">Most Recent</option>
                <option value="old">Most Old</option>
                <option value="incorrect">Most Incorrect</option>
                <option value="correct">Most Correct</option>
              </select>
            </div>
            <div class="">
              <span>Section: </span>
              <select class="" name="section" style="width:100px;">
                <option value="0" selected>All</option>
                @foreach ($sections as $key => $s)
                  <option value="{{$s->section}}" >{{$s->section}}</option>
                @endforeach
              </select>
            </div>

          </div>
          <div class="load-container text-center" style="display:none;">
            Loading...
          </div>
          <section class="question-container">
            @foreach ($questions as $q => $val)

              <div class="mb-4 py-3 border-bottom">
                <div class="row">
                  <div class="col-md-8">
                    <h4><a href="/questions/{{$val->id}}">{{$val->question}}</a></h4>
                    <h6>Section: {{$val->section}}, Subsection: {{ $val->subs ?? 'N/A' }},
                      Correct: @if ($val->correct)
                               <span class="badge badge-success">{{$val->correct  }} </span>
                              @else
                                N/A
                              @endif,
                      Wrong: @if ($val->wrong)
                              <span class="badge badge-danger">{{$val->wrong}} </span>
                              @else
                                N/A
                              @endif</h6>
                  </div>
                  <div class="col-md-4 ml-auto">
                    <ul class="nav d-flex justify-content-end">
                      <li class="nav-item"><a href="/question/edit/{{$val->id}}" class="px-1">Edit</a>|</li>
                      <li class="nav-item"><a href="/questions/{{$val->id}}" class="px-1">Details</a>|</li>
                      <li class="nav-item"><a href="/question/delete{{$val->id}}" class="px-1">Remove</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            @endforeach
            {{$questions->links()}}
        </section>
      </div>
    </div>
  </div

@stop
