@extends('layouts.question_layout')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
          <h2>Create Many Questions</h2>
          <p id="ajax-error"></p>
        <form class=""  method="post">
           {{ csrf_field() }}

           <div class="form-group">
             <label for="section">Question</label>
             <input class="form-control" type="text" name="question" value="">
           </div>
           <div class="form-group">
             <label for="section">Section</label>
             <input class="form-control" type="number"  max="13" min="1" name="section" value="">
           </div>
           <div class="form-group">
             <label for="subsection">Subsection</label>
             <select id="subsection-select" class="form-control" name="subsection[]" multiple>
               <option value="" default>n/a</option>
               @foreach ($subsections as $key => $sub)
                 <option value="{{$sub->id}}" >{{$sub->number}} - {{$sub->name}}</option>
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
        <p id="ajax-message"></p>
      </div>
    </div>
  </div

@stop
