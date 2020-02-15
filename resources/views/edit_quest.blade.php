@extends('layouts.question_layout')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
          <h2>Create a Question</h2>
        <form class="" action="/question/update/{{$question->id}}" method="post">
           {{ csrf_field() }}
           <div class="form-group">
             <label for="section">Question</label>
             <input class="form-control" type="text" name="question" value="{{$question->question}}">
           </div>
           <div class="form-group">
             <label for="section">Section</label>
             <input class="form-control" type="number"  max="20" min="1" name="section" value="{{$question->section}}">
           </div>
           <div class="form-group">
             <label for="subsection">Subsection</label>
             <select id="subsection-select" class="form-control" name="subsection[]" multiple>
               <option value="" default>n/a</option>
               @foreach ($subsect as $key => $sub)
                 <option value="{{$sub->id}}"  @if( in_array($sub->id, $selected)) selected @endif>{{$sub->number}} - {{$sub->name}}</option>
               @endforeach
             </select>
           </div>
           <div class="form-group">
             <label for="answer">Answer</label>
              <div id="toolbar">
             <div id="editor">
               </div>
             </div>
             <textarea id="answer" class="d-none" name="answer" rows="8" cols="80"></textarea>
           </div>
           <div class="form-group">
             <input class="btn btn-primary" type="submit"  value="Submit">
           </div>
        </form>
      </div>
    </div>
  </div

@stop
