@extends('layouts.app', ['subpage' => true, 'noheader' => true])

@section('content')
@if($experiment->template)
{!! $preset !!}
@else
{{--  --------------------------------  Header  --------------------------------------------------------- --}}
@include('frontend.partials.header')
{{--  --------------------------------  End header --------------------------------------------------------- --}}
<div class="container" style="margin-top:30px;">
{{--  --------------------------------  Titulok a popis --------------------------------------------------------- --}}
<div class="row">
  <div class="col-md-12 comparison mb-5">
    <h1>{{ $experiment->title }}</h1>
  </div>
</div>
{{-- --------------------------------  Koniec titulku a popisu --------------------------------------------------------- --}}
{{-- --------------------------------  Schémy --------------------------------------------------------- --}}
<div class="div_choice" id="div_choice">
  @foreach($experiment->schemes as $scheme)
  <fieldset class="schemes">
  <div class="tile" id="check_{{ $scheme->prefix }}">
      <span>
            <label for="choice_{{ $scheme->prefix }}" id="choice_label_{{ $scheme->prefix }}" class="checkbox-choice-label">{{ $scheme->title }} ({{ $scheme->shortcut }})</label>
            <input type="checkbox" name="choice_{{ $scheme->prefix }}" value="1" id="choice_{{ $scheme->prefix }}">
      </span>
      <div class="img_holder">
        <div class='image'>
              <img src="{{ $scheme->schema }}" alt="{{ $scheme->title }}">
        </div>
        <div class="sum">
              <span class="text">
             {{ $scheme->description }}
              </span>
          </div>
      </div>
  </div>
  </fieldset>
  @endforeach
</div>   
{{-- --------------------------------  Koniec schem --------------------------------------------------------- --}}
<div id='modal'></div>
{{-- --------------------------------  Priklady  --------------------------------------------------------- --}}
    <div class="row mt-5">
      <div id="div_radio" class="col-xs-12 col-sm-9 col-lg-9">
        @foreach ($experiment->examples as $example)
        <label for="radio_demo{{ $example->id }}" class="radiobox-label">{{ $example->title }}</label>
        <input type="radio" name="radio_demos" id="radio_demo{{ $example->id }}">
        @endforeach
      </div>
    </div>
{{-- --------------------------------  Koniec prikladov --------------------------------------------------------- --}}
{{-- --------------------------------  Buttony --------------------------------------------------------- --}}  
<div class="tab-content" id="home1"> 
  <div class="row simulation mt-5">
    <div class="col-md-3">
      <h2>Simulations</h2>
    </div>
    <div class="col-md-4">
      <div id="div_check_comparisons">
        <label for="checkbox_comparisons">Show history</label>
        <input type="checkbox" name="checkbox_comparisons" id="checkbox_comparisons">
      </div>
    </div>
    <div class="col-md-5 text-right">
      <button id="switchButton" class="d-inline-block btn btn-primary">Toggle Sliders / Text Inputs</button>
      @if($experiment->run_button)
      <button id="runButton" class="d-inline-block btn btn-danger">Run</button>
      @endif
    </div>
  </div>

  <div class="row comparisons mb-4">
  </div>
{{-- --------------------------------  Koniec buttonov --------------------------------------------------------- --}}
  <div class="row"> 
{{-- --------------------------------  Slajdre a checkboxes --------------------------------------------------------- --}}
          <div class="col-xs-12 col-sm-4 col-lg-4"> 
            <fieldset class="border p-2 mb-5 div_params_general"> 
              <legend>General</legend>
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
                      <div class="inputs" style="margin-bottom: 25px;">
                        <input type="number" id="par_{{ $slider->title }}_input" class="form-control">
                      </div>  
                    </div> 
                  </div>
                  @endforeach 
                </div> 
      
              @if(!$experiment->layout->checkboxes->isEmpty())
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
                    <div class="inputs" style="margin-bottom: 25px;">
                      <input type="number" id="par_{{ $slider->title }}_input" class="form-control">
                    </div>  
                  </div>
                </div>
                @endforeach
              @endforeach
              </div>
              @endif
            </fieldset>
          @foreach ($experiment->schemes()->has('sliders')->get() as $comparison)
          <fieldset class="border p-2 mb-5 div_params_{{ $comparison->prefix }}"> 
            <legend>{{ $comparison->title }}</legend>
              <div class="row">       
                @foreach ($comparison->sliders()->doesntHave('dependentCheckboxes')->where('visible',1)->orderBy('sorting')->get() as $slider)
                <div class="col-12 col-md-{{ $slider->columns }} mb-4">
                  <div id="div_{{ $slider->title }}" class="vstup">
                    <label for="slider_{{ $slider->title }}">{{ ($slider->label) ?: $slider->title }}:</label>
                    <div class="sliders_show">
                    <div id="slider_{{ $slider->title }}">    
                        <div id="par_{{ $slider->title }}" class="ui-slider-handle paramClass"></div>
                    </div>
                    </div>
                    <div class="inputs" style="margin-bottom: 25px;">
                      <input type="number" id="par_{{ $slider->title }}_input" class="form-control">
                    </div>  
                  </div> 
                </div>
                @endforeach 
              </div> 

            @if(!$comparison->checkboxes->isEmpty())
            <div class="row mt-5">
            @foreach ($comparison->checkboxes as $box)
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
                  <div class="inputs" style="margin-bottom: 25px;">
                    <input type="number" id="par_{{ $slider->title }}_input" class="form-control">
                  </div>  
                </div>
              </div>
              @endforeach
            @endforeach
            </div>
            @endif
          </fieldset>
          @endforeach
          <div class="row mt-5">
            @foreach ($experiment->layout->checkboxes as $box)
              <div id="div_check_{{ $box->attribute_name }}" class="col-12 col-md-12 mb-5">
                <label for="checkbox_{{ $box->attribute_name }}">{{ $box->title }}</label>
                <input type="checkbox" name="checkbox_{{ $box->attribute_name }}" id="checkbox_{{ $box->attribute_name }}" class="toggle{{ $box->id }}">
              </div>
              @foreach ($box->dependentSliders->where('visible', 1) as $slider)
              <div class="col-12 col-md-6 mb-5 div_checkbox_{{ $slider->comparisonExperiment->prefix }}">
                <div id="div_{{ $slider->title }}" class="vstup2">
                  <label for="slider_{{ $slider->title }}">{{ $slider->title }}:</label>
                  <div class="sliders_show">
                  <div id="slider_{{ $slider->title }}">   
                      <div id="par_{{ $slider->title }}" class="ui-slider-handle paramClass"></div>
                  </div>
                  </div>
                  <div class="inputs" style="margin-bottom: 25px;">
                    <input type="number" id="par_{{ $slider->title }}_input" class="form-control">
                  </div>  
                </div>
              </div>
              @endforeach
            @endforeach
            </div>
         </div>
{{-- -------------------------------- Koniec  slajdrov a checkboxes --------------------------------------------------------- --}}
{{-- --------------------------------  Zaciatok grafu --------------------------------------------------------- --}}
         <div id="results" class="col-xs-12 col-sm-8 col-lg-8">  
          <div id="loader" class="loader"> </div>
          <div id="plotdiv"></div> 
         </div>
{{-- --------------------------------  Koneic grafu --------------------------------------------------------- --}}
      </div>
</div>
</div>
<footer>
  Attila Mucska - Bakalárska práca 2021
</footer>
@endif
@endsection

@section('js')
    @include('frontend.graphs.jsPartials.comparison')
    @if($experiment->custom_js)
    {!! $experiment->custom_js !!}
    @endif
@endsection