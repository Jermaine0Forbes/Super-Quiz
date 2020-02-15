@extends('layouts.subsect_layout')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
          <h2 class="text-center">{{$subsect->number}}: {{$subsect->name}}</h2>
          <div class="nav bg-primary mb-4">
              <a href="/subsections/edit/{{$subsect->id}}" class="text-white nav-link">Edit</a>
              <a href="/subsections/delete/{{$subsect->id}}" id="btn-delete" class="text-white nav-link">Delete</a>
          </div>

      </div>
    </div>
  </div

@stop
