@extends('layouts.app', ['subpage' => true])
@section('content')
@if($experiment->template)
{!! $preset !!}
@else
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
    @endif
@endsection

@section('js')
    @include('frontend.graphs.jsPartials.graph1')
@endsection