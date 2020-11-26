@extends('layouts.app')

@section('content')
<h6>{{ $experiment->title }}</h6>
    
    <div class="row"> 
        <div class="col-xs-12 col-sm-6 col-lg-6"> 
           {!! $experiment->description !!}
        </div>
    </div>
    
    <p class="ui-state-default ui-corner-all ui-helper-clearfix" style="padding:4px;margin:20px 0 30px;">
    Simulations
    </p>
    
    <div class="row"> 
    
            
            <div class="col-xs-12 col-sm-4 col-lg-4"> 
            <fieldset> 
              <div class="row">       
                @foreach ($experiment->layout->sliders()->doesntHave('dependentCheckboxes')->where('visible',1)->get() as $slider)
                <div class="col-12 col-md-6 mb-4">
                  <div id="div_{{ $slider->title }}" class="vstup">
                    <label for="slider_{{ $slider->title }}">{{ $slider->title }}:</label>
                    <div id="slider_{{ $slider->title }}">    
                        <div id="par_{{ $slider->title }}" class="ui-slider-handle paramClass"></div>
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
                  <div id="slider_{{ $slider->title }}">   
                      <div id="par_{{ $slider->title }}" class="ui-slider-handle paramClass"></div>
                  </div>
                </div>
              </div>
              @endforeach
            @endforeach
            </div>
    
            {{-- <div id="div_sats">
            <div id="div_Umin" class="vstup">
              <label for="slider_Umin">Umin:</label>
              <div id="slider_Umin">   
                  <div id="par_Umin" class="ui-slider-handle"></div>
              </div>
            </div>
            <div id="div_Umax" class="vstup">
              <label for="slider_Umax">Umax:</label>
              <div id="slider_Umax">   
                  <div id="par_Umax" class="ui-slider-handle"></div>
              </div>
            </div>
            </div> --}}
    
            </fieldset>  
           </div>
           
           <div id="results" class="col-xs-12 col-sm-8 col-lg-8">  
            <div id="loader" class="loader"> </div>
            <div id="plotdiv"></div>   
           </div>
        </div>
              
        </div>
    </div>
    
@endsection

@section('js')
    @include('frontend.graphs.jsPartials.graph1')
@endsection