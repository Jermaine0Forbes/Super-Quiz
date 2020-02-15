<header class="bg-primary mb-5">
  <div class="container">
    <section class="row justify-content-center">
      <div class="col-md-10">

        <nav class=" nav">
          <li class="nav-item"><a href="{{route('home')}}" class="nav-link text-white"> Home</a></li>
          <li class="nav-item"><a href="{{route('quiz')}}" class="nav-link text-white"> Quiz</a></li>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link text-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Question</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="{{route('quest.create')}}">Create</a>
              <a class="dropdown-item" href="{{ route('quest.list')}}">List</a>
              <a class="dropdown-item" href="{{route('quest.create.ajax')}}">AJAX Create</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link text-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Subsection</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="{{route('sub.create')}}">Create</a>
              <a class="dropdown-item" href="{{route('sub.list')}}">List</a>
                <a class="dropdown-item" href="{{route('sub.create.ajax')}}">AJAX Create</a>

            </div>
          </li>
        </nav>
      </div>
    </section>
  </div>
</header>
