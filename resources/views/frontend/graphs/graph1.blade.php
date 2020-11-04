@extends('layouts.app')

@section('content')
<h6>Open loop (transfer function based) and closed loop 2DOF P control based constrained
    setpoint feedforward implementations with a unit setpoint step</h6>
    
    <div class="row"> 
        <div class="col-xs-12 col-sm-6 col-lg-6"> 
            <!--<b>CIM:</b> -->
            <img src="{{ asset('img/symetry2020_s_FO.png') }}" alt="simulation scheme"  width="400">  
        </div>
        <!--
        <div class="col-xs-12 col-sm-6 col-lg-6">
            <b>CRM:</b>
            <img src="img/ifacWC2017_s_FOPDT_DFF_DOdi.png" alt="simulation scheme" width="500"> 
        </div>
        -->
    </div>
    
    <p class="ui-state-default ui-corner-all ui-helper-clearfix" style="padding:4px;margin:20px 0 30px;">
    Simulations
    </p>
    
    <div class="row"> 
    
            
            <div class="col-xs-12 col-sm-4 col-lg-4"> 
            <fieldset>        
            <div id="div_params">
            <div id="div_tsim" class="vstup">
              <label for="slider_tsim">tsim:</label>
              <div id="slider_tsim">    
                  <div id="par_tsim" class="ui-slider-handle"></div>
              </div>
            </div>       
    <!--        
            <div id="div_Ts" class="vstup">
              <label for="slider_Ts">Ts:</label>
              <div id="slider_Ts">    
                  <div id="par_Ts" class="ui-slider-handle"></div>
              </div>
            </div>          
    -->
    
            <div id="div_tw" class="vstup">
              <label for="slider_tw">tw:</label>
              <div id="slider_tw">    
                  <div id="par_tw" class="ui-slider-handle"></div>
              </div>
            </div>
            <div id="div_w" class="vstup">
              <label for="slider_w">w:</label>
              <div id="slider_w">  
                  <div id="par_w" class="ui-slider-handle"></div>
              </div>
            </div>     
            
            <div id="div_Ks" class="vstup">
              <label for="slider_Ks">Ks:</label>
              <div id="slider_Ks">   
                  <div id="par_Ks" class="ui-slider-handle"></div>
              </div>
            </div>
            <div id="div_Ksm" class="vstup">
              <label for="slider_Ksm">Km:</label>
              <div id="slider_Ksm">   
                  <div id="par_Ksm" class="ui-slider-handle"></div>
              </div>
            </div>
    
            <div id="div_a" class="vstup">
              <label for="slider_a">a:</label>
              <div id="slider_a">   
                  <div id="par_a" class="ui-slider-handle"></div>
              </div>
            </div>
            <div id="div_am" class="vstup">
              <label for="slider_am">am:</label>
              <div id="slider_am">   
                  <div id="par_am" class="ui-slider-handle"></div>
              </div>
            </div>         
    
            <div id="div_KP" class="vstup">
              <label for="slider_KP">KP:</label>
              <div id="slider_KP">    
                  <div id="par_KP" class="ui-slider-handle"></div>
              </div>
            </div>  
    
            <div id="div_Tc" class="vstup">
              <label for="slider_Tc">Tc:</label>
              <div id="slider_Tc">    
                  <div id="par_Tc" class="ui-slider-handle"></div>
              </div>
            </div> 
            </div> 
    
            <div id="div_sats">
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
            </div>
    
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