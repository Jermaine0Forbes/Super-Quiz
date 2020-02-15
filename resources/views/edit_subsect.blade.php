@extends('layouts.subsect_layout')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
          <h2>Edit Subsection</h2>
        <form class="" action="/subsections/update/{{$subsect->id}}" method="post">
           {{ csrf_field() }}
           <div class="form-group">
             <label for="number">Number</label>
             <input class="form-control" type="text" name="number" value="{{$subsect->number}}">
           </div>
           <div class="form-group">
             <label for="name">Name</label>
             <input class="form-control" type="text"   name="name" value="{{$subsect->name}}">
           </div>

           <div class="form-group">
             <input class="btn btn-primary" type="submit"  value="Submit">
           </div>
        </form>
      </div>
    </div>
  </div

@stop
