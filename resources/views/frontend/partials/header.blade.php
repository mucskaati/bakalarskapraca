<header class="bg small-header">    
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container">
      <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('img/logo-white.svg') }}" width="160px" class="d-inline-block align-top" alt="">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Single experiments</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              @foreach ($fos as $fo)
              <a class="dropdown-item" href="{{ route('graph_fo', ['id' => $fo->id, 'slug' => $fo->slug]) }}">{{ $fo->title }}</a>
              @endforeach
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Path based experiments</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              @foreach ($nyquist as $nyq)
              <a class="dropdown-item" href="{{ route('graph_nyquist', ['id' => $nyq->id, 'slug' => $nyq->slug]) }}">{{ $nyq->title }}</a>
              @endforeach
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Comparisons</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              @foreach ($comparisons as $comparison)
              <a class="dropdown-item" href="{{ route('comparison', ['id' => $comparison->id, 'slug' => $comparison->slug]) }}">{{ $comparison->title }}</a>
              @endforeach
            </div>
          </li>
        </ul>
      </div>
      </div>
  </nav>
</header>