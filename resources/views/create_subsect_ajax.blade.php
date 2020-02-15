@extends('layouts.subsect_layout')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
          <h2>Create Many Subsections</h2>
          <p id="ajax-error"></p>
        <form class="" action="/subsections/store" method="post">
           {{ csrf_field() }}
           <div class="form-group">
             <label for="number">Number</label>
             <input class="form-control" type="text" name="number" value="">
           </div>
           <div class="form-group">
             <label for="section">Name</label>
             <input class="form-control" type="text"  name="name" value="">
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
