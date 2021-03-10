@extends('layouts.app', ['subpage' => true, 'noheader' => true])
@section('content')
@if($experiment->template)
{!! $preset !!}
@else
{{--  --------------------------------  Header  --------------------------------------------------------- --}}
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
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">FO Controllers</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          @foreach ($fos as $fo)
          <a class="dropdown-item" href="{{ route('graph_fo', ['id' => $fo->id, 'slug' => $fo->slug]) }}">{{ $fo->title }}</a>
          @endforeach
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Comparisons</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          @foreach ($compars as $comparison)
          <a class="dropdown-item" href="{{ route('comparison', ['id' => $comparison->id, 'slug' => $comparison->slug]) }}">{{ $comparison->title }}</a>
          @endforeach
        </div>
      </li>
    </ul>
  </div>
  </div>
</nav>
</header>
{{--  --------------------------------  End header --------------------------------------------------------- --}}
<div class="container" style="margin-top:30px;">
<div class="graf_fo">
{{--  --------------------------------  Titulok a popis --------------------------------------------------------- --}}
    <h1>{{ $experiment->title }}</h1>
    
    <div class="row"> 
        <div class="col-xs-12 col-sm-6 col-lg-6"> 
           {!! $experiment->description !!}
        </div>
    </div>
{{-- --------------------------------  Koniec titulku a popisu --------------------------------------------------------- --}}
{{-- ---------------------------- Buttony Toggle a Run ----------------------------------------------- --}}    
    <div class="row simulation mt-5">
      <div class="col-md-6">
      <h2>Simulations</h2>
      </div>
      <div class="col-md-6 text-right">
        <button id="switchButton" class="d-inline-block btn btn-primary">Toggle Sliders / Text Inputs</button>
        @if($experiment->run_button)
        <button id="runButton" class="d-inline-block btn btn-danger">Run</button>
        @endif
      </div>
    </div>
{{--  --------------------------------  Koniec buttonov --------------------------------------------------------- --}}
    <div class="row"> 
{{-- ------------------------ Slajdre a checkboxy ----------------------------------------------- --}}
            <div class="col-xs-12 col-sm-4 col-lg-4"> 
            <fieldset> 
              <div class="row">       
                @foreach ($experiment->layout->sliders()->doesntHave('dependentCheckboxes')->where('visible',1)->orderBy('sorting')->get() as $slider)
                <div class="col-12 col-md-{{ $slider->columns }} mb-4">
                  <div id="div_{{ $slider->title }}" class="vstup">
                    <label for="slider_{{ $slider->title }}">{{ ($slider->label) ?: $slider->title }}:</label>
                    <div class="sliders_show">
                    <div id="slider_{{ $slider->title }}">    
                        <div id="par_{{ $slider->title }}" class="ui-slider-handle paramClass"></div>
                    </div>
                    </div>
                    <div class="inputs">
                      <input type="number" id="par_{{ $slider->title }}_input" class="form-control">
                    </div>  
                  </div> 
                </div>
                @endforeach 
              </div> 

            <div class="row mt-5">
            @foreach ($experiment->layout->checkboxes as $box)
              <div id="div_check_{{ $box->attribute_name }}" class="col-12 col-md-12 mb-5">
                <label for="checkbox_{{ $box->attribute_name }}">{{ $box->title }}</label>
                <input type="checkbox" name="checkbox_{{ $box->attribute_name }}" id="checkbox_{{ $box->attribute_name }}" class="toggle{{ $box->id }}">
              </div>
              @foreach ($box->dependentSliders->where('visible', 1) as $slider)
              <div class="col-12 col-md-6 mb-5">
                <div id="div_{{ $slider->title }}" class="vstup">
                  <label for="slider_{{ $slider->title }}">{{ $slider->title }}:</label>
                  <div class="sliders_show">
                  <div id="slider_{{ $slider->title }}">   
                      <div id="par_{{ $slider->title }}" class="ui-slider-handle paramClass"></div>
                  </div>
                  </div>
                  <div class="inputs">
                    <input type="number" id="par_{{ $slider->title }}_input" class="form-control">
                  </div>  
                </div>
              </div>
              @endforeach
            @endforeach
            </div>
            </fieldset>  
           </div>
{{--  --------------------------------  Koniec slajdrov a checkboxov --------------------------------------------------------- --}}
{{--  --------------------------------  Vykreslenie grafu --------------------------------------------------------- --}}
           <div id="results" class="col-xs-12 col-sm-8 col-lg-8">  
            <div id="loader" class="loader"> </div>
            <div id="plotdiv"></div> 
           </div>
{{--  --------------------------------  Koniec vykreslenia grafu --------------------------------------------------------- --}}
        </div>
</div>
</div>
<footer>
  Attila Mucska - Bakalárska práca 2021
</footer>
    @endif
@endsection

@section('js')
    @include('frontend.graphs.jsPartials.graph1')
    @if($experiment->custom_js)
    {!! $experiment->custom_js !!}
    @endif
@endsection