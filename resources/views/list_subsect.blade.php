@extends('layouts.subsect_layout')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
          <h1 class="mb-4">Subsections</h1>
          @if (count($subsections) > 0)
            @foreach ($subsections as $sub => $s)
              <div class="mb-4 py-3 border-bottom">
                <div class="row">
                  <div class="col-md-8">
                    <h4><a href="/subsections/{{$s->id}}"> Subsection: {{$s->number}}</a></h4>
                    <h6>Name: {{$s->name}}</h6>
                  </div>
                  <div class="col-md-4 ml-auto">
                    <ul class="nav d-flex justify-content-end">
                      <li class="nav-item"><a href="/subsections/edit/{{$s->id}}" class="px-1">Edit</a>|</li>
                      <li class="nav-item"><a href="/subsections/{{$s->id}}" class="px-1">Details</a>|</li>
                      <li class="nav-item"><a href="/subsections/delete{{$s->id}}" class="px-1">Remove</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              {{-- <div class="mb-4 py-3 border-bottom">
                <h3><a href="/subsections/{{$s->id}}"> Subsection: {{$s->number}}</a></h3>
                <h4>Name: {{$s->name}}</h4>
              </div> --}}
            @endforeach
          @else
            <h3 class="text-muted">No content here</h3>
          @endif

      </div>
    </div>
  </div

@stop
