@extends('layouts.quiz_layout')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
          <h1 class="mb-4">Start Quiz</h1>
          <div class="question-settings">
            <form class="" action="index.html" method="post">
              <div class="row border-bottom">
                <div class="col-md-6">
                  <h3>Timed</h3>
                    <label class="switch">
                      <input name="timed" type="checkbox">
                      <span class="slider round"></span>
                    </label>
                </div>
                <div class="col-md-6">

                </div>
              </div>
              <div class="row  border-bottom">
                <div class="col-4">
                  <h3>Number</h3>
                  <input class="form-control mb-3" type="text" name="number" value="5">
                </div>
              </div>
              <div class="row   border-bottom">
                <div class="col-4">
                  <h3>Section</h3>
                    <select  class="form-control mb-3"  name="section">
                      <option value="0" selected>All</option>
                      @foreach ($sections as $key => $sect)
                        <option value="{{$sect->section}}">{{$sect->section}}</option>
                      @endforeach
                    </select>
                </div>
              </div>

              <a id="btn-options" href="#" class="btn btn-primary btn-lg">submit</a>
            </form>

          </div>
          <div class="question-container position-relative">

          </div>
      </div>
    </div>
  </div

@stop
