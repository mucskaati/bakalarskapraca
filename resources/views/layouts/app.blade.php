<!doctype html>
<html lang="en">
<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-176651432-2"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Interactive Controllers</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <!--<link rel="stylesheet" href="/resources/demos/style.css">    
   <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet"/>   -->
   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
   <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
  @if(!isset($noheader))
  <header class="bg @if(isset($subpage)) small-header @endif">    
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
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">FO Controllers</a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @foreach ($fos as $fo)
            <a class="dropdown-item" href="{{ route('graph_fo', ['id' => $fo->id, 'slug' => $fo->slug]) }}">{{ $fo->title }}</a>
            @endforeach
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Nyquist Controllers</a>
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
  @yield('header')
  </header>
  @endif

{{-- <p class="ui-state-default ui-corner-all ui-helper-clearfix" style="padding:4px;margin-bottom:35px">
  Asymmetries in the disturbance compensation
methods for the stable and unstable first order plants
</p> --}}

 <!--<div id="loader" class="loader"> 
<img src="img/loading.gif" alt="loading">
</div>--> 

@yield('content')

@if(!isset($noheader))
<footer>
  Attila Mucska - Bakalárska práca 2021
</footer>
@endif
@yield('js')
</body>
</html>