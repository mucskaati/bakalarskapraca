<script src="{{ asset('js/jquery.ui.touch-punch.min.js') }}"></script>
<script>
    $( function() {
     //==================zvacsovanie thumbnailov==============================
     //https://stackoverflow.com/questions/32486256/enlarge-image-when-hovering-over-parent-element
     //http://jsfiddle.net/k3oq1899/1/
      var currentMousePos = { x: -1, y: -1 };
      $(document).mousemove(function (event) {
          currentMousePos.x = event.pageX;
          currentMousePos.y = event.pageY;
          if($('#modal').css('display') != 'none') {
              $('#modal').css({
                  top: currentMousePos.y +12,
                  left: currentMousePos.x - 237     //+12
              });
          }
      });
      $('.image').on('mouseover', function() {
          var image = $(this).find('img');
          var modal = $('#modal');
          $(modal).html(image.clone());
          $(modal).css({
              top: currentMousePos.y + 12,
              left: currentMousePos.x - 237
          });
          $(modal).show();
          
      });
      $('.image').on('mouseleave', function() {
          $(modal).hide();
      });   
      
      //==========================================================
  
      $('.sum').hide();
      var plotarray =[];
      
      
      var varsGraph = [
        @foreach($experiment->graphs as $graphKey => $graph)
            @foreach($graph->traces as $key => $trace)
             {'x': '{{ $trace->xaxis['id'] }}', 'y' : '{{ $trace->yaxis['id'] }}' },
            @endforeach
        @endforeach
      ]
      var varsOrder = ["y", "u", "dor", "vf"];
      var schemesPlotNames = {
        @foreach($experiment->schemes as $scheme)
        {{ $scheme->prefix }}: {'name': '{{ $scheme->title }}', 'prefix' : '{{ $scheme->prefix }}', 'color': '{{ $scheme->trace_color }}' },
        @endforeach
      }
      var plotNames = {
                          "NR_CA_FOTD_b1": "NR-CA",
                          "Miky_FOTD_b2": "FSP2",
                      };
      var colors = ['#1f77b4','#ff7f0e','#2ca02c','#d62728','#9467bd','#8c564b','#e377c2','#7f7f7f','#bcbd22','#17becf'];                    
                      
  /*
      '#1f77b4',  // muted blue
      '#ff7f0e',  // safety orange
      '#2ca02c',  // cooked asparagus green
      '#d62728',  // brick red
      '#9467bd',  // muted purple
      '#8c564b',  // chestnut brown
      '#e377c2',  // raspberry yogurt pink
      '#7f7f7f',  // middle gray
      '#bcbd22',  // curry yellow-green
      '#17becf'   // blue-teal
  */                    
      

      //---------------------------------------------------Layout---------------------------------------------------------------
      var layout = {
              grid: {rows: {{ $experiment->layout->rows }}, columns: {{ $experiment->layout->columns }} },
              height: {{ $experiment->layout->height }},
              margin: {{ $experiment->layout->margin }},
              xaxis: {{ $experiment->layout->xaxis }},
              @foreach($experiment->graphs as $key => $graph)
              yaxis{{ $key+1 }}: {
                autorange: true,
                range: [0, 2]
              },
              @endforeach
              annotations: 
              [
                @foreach($experiment->graphs as $graph)
                { text: "{{ $graph->annotation_title }}",
                  font: { size: 14,
                          color: 'black', },
                  textangle: {{ $graph->annotation_angle }}, 
                  showarrow: false,
                  align: '{{ $graph->align }}',
                  x: {{ $graph->xaxis }}, //position in x domain
                  y: {{ $graph->yaxis }}, //position in y domain
                  xref: 'paper',
                  yref: 'paper',
                },
                @endforeach      
              ]
      };

       //------------------------------------------Sliders connected to schemes -----------------------------------------------------------------     
       @foreach ($experiment->schemes as $comparison)
       @foreach($comparison->sliders->where('default_function', null) as $slider)
          var parv_{{ $slider->title }} = { value: {{ $slider->default  }}, step: {{ $slider->step }} };
          var parv_{{ $slider->title }}_input = { value: {{ $slider->default  }}, step: {{ $slider->step }} };
       @endforeach

        @foreach($comparison->sliders->where('default_function','!=', null) as $slider)
          var parv_{{ $slider->title }} = { value: {{ $slider->default_function  }}, step: {{ $slider->step }} };
          var parv_{{ $slider->title }}_input = { value: {{ $slider->default_function  }}, step: {{ $slider->step }} };
        @endforeach
      @endforeach

      @foreach ($experiment->schemes as $comparison)
        @foreach($comparison->sliders as $slider)
            createSlider("#slider_{{ $slider->title }}", "#par_{{ $slider->title }}", {{ $slider->min }}, {{ $slider->max }}, parv_{{ $slider->title }}, {{ $slider->step }});
            @if(!$experiment->run_button)
            $("#slider_{{ $slider->title }}").on( "slidestop", function( event, ui ) {
                setTimeout(() => { runAjaxCall() }, 100);
            });
            @endif
            @endforeach 
      @endforeach
      //-------------------------------------------Slider connected to experiment layout -----------------------------------
      @foreach($experiment->layout->sliders->where('default_function', null) as $slider)
        var parv_{{ $slider->title }} = { value: {{ $slider->default  }} };
        var parv_{{ $slider->title }}_input = { value: {{ $slider->default  }} };
      @endforeach

      @foreach($experiment->layout->sliders->where('default_function','!=', null) as $slider)
        var parv_{{ $slider->title }} = { value: {{ $slider->default_function  }} };
        var parv_{{ $slider->title }}_input = { value: {{ $slider->default_function  }} };
      @endforeach
      
    
      @foreach($experiment->layout->sliders as $slider)
        createSlider("#slider_{{ $slider->title }}", "#par_{{ $slider->title }}", {{ $slider->min }}, {{ $slider->max }}, parv_{{ $slider->title }}, {{ $slider->step }});
        @if(!$experiment->run_button)
            $("#slider_{{ $slider->title }}").on( "slidestop", function( event, ui ) {
                setTimeout(() => { runAjaxCall() }, 100);
            });
        @endif
        @endforeach   
       
      runAjaxCall()
  
      //document.getElementById("par_tsim_input").step = ".1";
      //$("#par_tsim_input").attr('step', parv_tsim.step);
       
      setAllSliders();
      var counter = 0;

      var parv_json = {
        what: [],
        @foreach ($experiment->schemes as $comparison)
          @foreach($comparison->sliders as $slider)
                "{{ $slider->title }}": parv_{{ $slider->title }}.value,
          @endforeach
        @endforeach

        @foreach($experiment->layout->sliders as $slider)
                "{{ $slider->title }}": parv_{{ $slider->title }}.value,
        @endforeach
             
      };
      
      //-------------------------------------------------------- Ajax call ----------------------------------------------------------
      function runAjaxCall() { 
      $.ajax({
        type: "GET",
        url: "http://apps.iolab.sk:9000/symetry2",
        //data: {"tsim":parv_tsim.value,"Ts":parv_Ts.value,"tw":parv_tw.value,"w":parv_w.value,"tvi":parv_tvi.value,"vi":parv_vi.value,"tvo":parv_tvo.value,"vo":parv_vo.value,"Ks":parv_Ks.value,"Ksm":parv_Ksm.value,"a":parv_a.value,"am":parv_am.value,"Kc":parv_Kc.value,"KP":parv_KP.value,"Tf":parv_Tf.value,"Tc":parv_Tc.value,"b":parv_b.value,"Umin":parv_Umin.value,"Umax":parv_Umax.value,"Uifmin":parv_Uifmin.value,"Uifmax":parv_Uifmax.value},
        //"Td":parv_Td.value,"Tdm":parv_Tdm.value,
        //data: {"vi":parv_vi},
        data: parv_json,
        dataType: 'json',
        beforeSend: function() {
          $('#loader').show();
          $( "fieldset" ).addClass( "elementDisabled" );
          $( "#div_button" ).addClass( "elementDisabled" );
          $( "#div_radio" ).addClass( "elementDisabled" );
        },
        complete: function(){
          $('#loader').hide();
          $( "fieldset" ).removeClass( "elementDisabled" );
          $( "#div_button" ).removeClass( "elementDisabled" );
          $( "#div_radio" ).removeClass( "elementDisabled" );
        },
        success:function(data)   
        { console.log(data);

          $('.loader').hide();
          //$.each( data, function( key, value ) { console.log( key + ": " + value ); });   
          let vars = [];                //pre vymenovanie premennych pre kazdu simulacnu scemu
          let tasks = [];               //nazvy simulacnych schem
          $.each( data, function( key ) {
          //za predpokladu, ze navratove premenne z FAST API su okrem casu oznacene ako nazovPremennej_nieco_nieco, tak to rozdeli na prvom podrazovniku a do prvej premennej vlozi nazov pred podrazovnikm a do druhej za odrazovnikom
              //console.log( key );
              vars.push(key.substr(0,key.indexOf('_')));         
              tasks.push(key.substr(key.indexOf('_')+1)); 
          }); 
          vars.shift(); tasks.shift();  //odstrani casovu premennu z oboch poli
          vars = _.uniq(vars);    // vyfiltruje iba unikatne hodnoty v danom poli      
          tasks = _.uniq(tasks);      
          // console.log(tasks);
          //console.log(tasks);    
          t = data.t.split(",");
          let plotData = {};       //hodnoty kazdeho z grafov umiestnene do pola (nevyuziva sa, je len k dispozicii)
          let maxValues = {};      //maximalne hodnoty kazdeho z grafov (nevyuziva sa, je len k dispozicii)
          let maxs = [];
          let mins = [];
          let traceData = {};      //zostavenie jednotlivych grafov, je to potrebne pre plotly
          let i = 0;  let k = 0;       
          $.each( tasks, function( keyt, valuet ) {
              $.each( vars, function( keyv, valuev ) {
                  console.log(valuet); 
                  plotData[valuev + "_" + valuet] = data[valuev + "_" + valuet].split(",");  
                  maxValues[valuev + "_" + valuet] = Math.max(...(plotData[valuev + "_" + valuet]).map(Number));  
              }); 

              $.each( varsGraph, function( index, valueo ) {  
                  traceData[++i] = {
                  x: valueo['x'],
                  y: data[valueo['y'] + "_" + valuet].split(","), 
                  xaxis: 'x' + (index+1),
                  yaxis: 'y' + (index+1),
                  marker: {
                      color: (schemesPlotNames[valuet]['color']) ? schemesPlotNames[valuet]['color'] : colors[k + counter],
                      line: {color: 'transparent'}
                  },  
                  legendgroup: 'a' + k + counter, 
                  showlegend: false, 
                  name: schemesPlotNames[valuet]['name']+ " " + counter
                }; 
                  plotarray.push(traceData[i]); 
                  if (i % vars.length == 1)  {traceData[i].showlegend = "true";}                  
              });
              k++;
          });     
          //console.log( plotarray );
           
          i=0; 
          $.each( vars, function( keyv, valuev ) {
             ++i;
             $.each( tasks, function( keyt, valuet ) {
                  //maxs = maxs.concat(Math.max(...(plotData[valuev + "_" + valuet]).map(Number)));  
                  maxs = maxs.concat(maxValues[valuev + "_" + valuet]);
                  mins = mins.concat(Math.min(...(plotData[valuev + "_" + valuet]).map(Number)));
             });
             let maxsnew = maxs.filter(function(x) {
                  return x > -10 && x < 10;
             });
             //console.log("yaxis"+i);
             //console.log(maxs);
             //console.log(mins);
             //console.log(round(Math.min(...mins),1)-0.4);
            //  if (Math.max(...maxs)>10)
            //       {layout["yaxis"+i].autorange = false; layout["yaxis"+i].range = [round(Math.min(...mins),1)-0.4, round(Math.max(...maxsnew),1)+0.4]; }
            //  //else                                                      //toto je sice dobre, ale to netreba
            //  //     {layout["yaxis"+i].autorange = true; }
            //  maxs = []; mins = [];
          });
  
          let dor = data.dor_Miky_FOTD_b2.split(",");       //dor*(Kp-1/Kn)
          us_RM = dor.map(function(x) { return x *(parv_Kp.value-1/parv_Ksm.value); });
  
         
              //console.log($('#choice_noRM').is(":checked"));   
          if ($('#checkbox_sat').is(":checked") && counter>0) 
              { Plotly.addTraces($('#plotdiv')[0], plotarray); }
          else
          //Plotly.addTraces($('#plotdiv')[0], [{x: [100,200,300], y: [4, 5, 6]},{x: [100,200,300], y: [4, 5, 6],xaxis:'x2',yaxis: 'y2'}]);
          //
              { Plotly.newPlot($('#plotdiv')[0], plotarray, layout, {displaylogo: false, responsive: true}); }
          if ($('#checkbox_sat').is(":checked")) 
              { counter++; }
          else
              { counter = 0; }
          plotarray = [];
          maxs = [];
        }     
      }).done(function( o ) {
         // do something
      }); 
      }    
  
//----------------------------------------------Create Slider ----------------------------------------------------------------
function createSlider(idSlider, idPar, minValue, maxValue, defaultValue, stepValue) {
      let iddPar = $( idPar );
      $( idSlider ).slider({
        min:minValue,
        max:maxValue,
        value:defaultValue.value,
        step: stepValue,
        create: function() {
          iddPar.text( $( this ).slider( "value") );
          $(idPar+'_input').val(defaultValue.value);
          //runAjaxCall()
        },
        slide: function( event, ui ) {
          iddPar.text( ui.value );
          $(idPar+'_input').val(ui.value);  
          lastChangeInSlider = true;
        },
        change: function(event, ui) { 
          defaultValue.value = ui.value;
          @foreach ($experiment->schemes as $comparison)
          @foreach($comparison->sliders()->whereHas('dependencies')->get() as $slider)  
          if ( idPar == "#par_{{ $slider->title }}") {

                @foreach($slider->dependencies as $dependency)
                  parv_{{ $dependency->title }}.value =  {{ ($dependency->pivot->value_same_as_added) ? 'parv_'.$slider->title.'.value' : $dependency->pivot->value_function }};
                  $('#par_{{ $dependency->title }}').text(round(parv_{{ $dependency->title }}.value,3)); 
                  $( "#slider_{{ $dependency->title }}" ).slider( "value", parv_{{ $dependency->title }}.value ); 
                  changeSliderAndInput("parv_{{ $dependency->title }}");
                @endforeach

                @foreach($experiment->layout->checkboxes as $checkbox)
                //----------------- Aby sme dosiahli to ze ked sa pohne s nejakym slidrom 
                // ---------------  a checkbox je zakliknuty aby sa prepocital aj 
                //----------------  udaj v slidroch ktory su zavisli na checkboxe
                  @if($checkbox->slider_dependency_change)
                  if ( $("#checkbox_{{ $checkbox->attribute_name }}").prop("checked") )
                  { 
                    @foreach($checkbox->dependentSliders as $slider)
                    parv_{{ $slider->title }}.value =   {{ $slider->pivot->value_function }};
                    $('#par_{{ $slider->title }}').text(round(parv_{{ $slider->title }}.value,3)); 
                    $( "#slider_{{ $slider->title }}" ).slider( "value", parv_{{ $slider->title }}.value );
                    changeSliderAndInput("parv_{{ $slider->title }}");
                    @endforeach
                  } 
                  @endif
                @endforeach
          }
          @endforeach
          @endforeach
          
        },
      }); 
      };
  
//--------------------------------------------- Schemy -------------------------------------------------------------------
      $( function() {

          $('.div_params_general').show();  // Slajdre a checkboxy naviazane priamo na experiment ukazovat stale
          $('.div_checkbox_general').hide();
          //Pre kazdu schemu
          @foreach ($experiment->schemes as $key => $comparison)
          // Skry fieldsety defaultne
          $('.div_params_{{ $comparison->prefix }}').hide();
          $('.div_checkbox_{{ $comparison->prefix }}').hide();

           // Vytvor checkboxradio pre kazdu schemu
          $( "#choice_{{ $comparison->prefix }}").checkboxradio();

           // Zacekuj len prvy experiment defaultne a ukaz fieldsety prveho
          @if($key == 0) 
          $('#choice_{{ $comparison->prefix }}').prop('checked',true).checkboxradio('refresh')
          $('.div_params_{{ $comparison->prefix }}').show();
          $('.div_checkbox_{{ $comparison->prefix }}').show();
          @endif

          //Na klik zisti ci je checkboxradio zaceknuty
          $( "#choice_{{ $comparison->prefix }}").on('click', (e) => {
            if(!$( "#choice_label_{{ $comparison->prefix }}" ).hasClass('ui-checkboxradio-checked'))
            {
              $('.div_params_{{ $comparison->prefix }}').show();
              $('.div_checkbox_{{ $comparison->prefix }}').show();
              parv_json.what.push('{{ $comparison->prefix }}');
            } else {
              $('.div_params_{{ $comparison->prefix }}').hide();
              $('.div_checkbox_{{ $comparison->prefix }}').hide();
              parv_json.what = parv_json.what.filter(function(scheme){ return scheme != '{{ $comparison->prefix }}'; })
            }
          })
          @endforeach

         $( "#div_radio" ).controlgroup();
      } );  

//----------------------------------------------- Checkboxes ---------------------------------------------------------
  
$( function() {
        $( "input[type=checkbox]" ).checkboxradio({   
            //icon: false    
            //label: "custom label"
        });
    } );

  //Checkboxes connected to layout
  @foreach($experiment->layout->checkboxes as $checkbox)
     $( ".toggle{{ $checkbox->id }}" ).on( "change", handleToggle{{ $checkbox->id }} );
     function handleToggle{{ $checkbox->id }}( e ) {
      var target = $( e.target );
 
      if ( target.is( ":checked" ) ) {
        @foreach($checkbox->dependentSliders as $slider)
        parv_{{ $slider->title }}.value =  {{ $slider->pivot->value_function }};
        $('#par_{{ $slider->title }}').text(round(parv_{{ $slider->title }}.value,3)); 
        $( "#slider_{{ $slider->title }}" ).slider( "value", parv_{{ $slider->title }}.value );
        changeSliderAndInput("parv_{{ $slider->title }}");
        @endforeach
      } 
      else {
        @foreach($checkbox->dependentSliders as $slider)
        parv_{{ $slider->title }}.value =  {{ ($slider->default_function) ?: $slider->default }};
        $('#par_{{ $slider->title }}').text(round(parv_{{ $slider->title }}.value,3)); 
        $( "#slider_{{ $slider->title }}" ).slider( "value", parv_{{ $slider->title }}.value );
        changeSliderAndInput("parv_{{ $slider->title }}");
        @endforeach        
      }
     
    } 
    
  @endforeach

  //Checkboxes connected to schemes
  @foreach ($experiment->schemes as $key => $comparison)
  @foreach($comparison->checkboxes as $checkbox)
     $( ".toggle{{ $checkbox->id }}" ).on( "change", handleToggle{{ $checkbox->id }} );
     function handleToggle{{ $checkbox->id }}( e ) {
      var target = $( e.target );
 
      if ( target.is( ":checked" ) ) {
        @foreach($checkbox->dependentSliders as $slider)
        parv_{{ $slider->title }}.value =  {{ $slider->pivot->value_function }};
        $('#par_{{ $slider->title }}').text(round(parv_{{ $slider->title }}.value,3)); 
        $( "#slider_{{ $slider->title }}" ).slider( "value", parv_{{ $slider->title }}.value );
        changeSliderAndInput("parv_{{ $slider->title }}");
        @endforeach
      } 
      else {
        @foreach($checkbox->dependentSliders as $slider)
        parv_{{ $slider->title }}.value =  {{ ($slider->default_function) ?: $slider->default }};
        $('#par_{{ $slider->title }}').text(round(parv_{{ $slider->title }}.value,3)); 
        $( "#slider_{{ $slider->title }}" ).slider( "value", parv_{{ $slider->title }}.value );
        changeSliderAndInput("parv_{{ $slider->title }}");
        @endforeach        
      }
     
    } 
    
  @endforeach
  @endforeach

//----------------------------------------------------Toggle-------------------------------------------------------------

  $(".inputs").toggle();    
  $("#switchButton").click(function(){
      $(".sliders_show").toggle();
      $(".inputs").toggle();
  }); 

  $( "#runButton" ).click( function(  ) {         
            runAjaxCall();
  } );

  $(".toggle").click(function(){
        $("#div_sats").toggle();
  }); 

//----------------------------------------------------Functions----------------------------------------------------------
    
      function round(value, decimals) {
        //return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
        return Number(Math.sign(value) * Math.abs(value).toFixed(decimals));
      }
      
      function KpGain(Km,T1m,Tdm) {           //FSP1-4 P controller gain
          return round(T1m/Km/Tdm*Math.exp(-1+Tdm/T1m),6);
      };
      
      function KPGain(alfa,Tc) {           //setpoint feedforward PD gain
          return round((1/((alfa*Tc)*(alfa*Tc))-1),6);
      }; 
      
      function KDGain(alfa,Tc) {           //setpoint feedforward PD gain
          return round(2*(1/(alfa*Tc)-1)/alfa,6);
      }; 
      
      function beta1Gain(alfa,Tf,Tdm) {                 // Math.pow(4, 3)
          let beta1=4*Tf*alfa-4*Math.pow(Tf*alfa,3)+2*Math.pow(Tf*alfa,4)-Tdm*alfa+4*Tdm*Math.pow(alfa,2)*Tf-6*Tdm*alfa*Math.pow(Tf*alfa,2);
          beta1=(beta1+4*Tdm*alfa*Math.pow(Tf*alfa,3)-Tdm*alfa*Math.pow(Tf*alfa,4)-2+2*Math.exp(Tdm*alfa))/(Math.exp(Tdm*alfa)*alfa); 
          return round(beta1,2);
      };
      
      function beta2Gain(alfa,Tf,Tdm) {              
          let beta2=-8*Math.pow(Tf*alfa,3)+3*Math.pow(Tf*alfa,4)-Tdm*alfa+4*Tdm*alfa*alfa*Tf-6*Tdm*alfa*Math.pow(Tf*alfa,2)+4*Tdm*alfa*Math.pow(Tf*alfa,3);
          beta2=(beta2-Tdm*alfa*Math.pow(Tf*alfa,4)-1+Math.exp(Tdm*alfa)+6*Math.pow(Tf*alfa,2))/(Math.exp(Tdm*alfa)*alfa*alfa); 
          return round(beta2,2);
      };
      
      function alfaGain(T1m,Tdm) {           //stabilizing controller gain
          return round((1-Tdm/T1m)/Tdm,6);
      };
     
     function changeSlider(what) {
       let whatPart = what.substring(5);
       $('#par_'+whatPart).text(eval(what).value); 
       $( "#slider_"+whatPart ).slider( "value", eval(what).value );
     }
     
     function changeSliderAndInput(what) {
       let whatPart = what.substring(5);
       $('#par_'+whatPart).text(eval(what).value); 
       $( "#slider_"+whatPart ).slider( "value", eval(what).value );
       $('#par_'+whatPart+'_input').val(eval(what).value);
     }
     
      function setSlider(slider,inputbox) {
      //nastavi slider podla ciselneho vstupu a zaroven nastavi krok ciselneho vstupu
      $(inputbox).attr('step', eval("parv_"+inputbox.split('_')[1]).step); 
        $(inputbox).keyup( function(){
            //$( slider ).slider( "option", "value", parseInt($(this).val()) );
            $( slider ).slider( "option", "value", ($(this).val()) );
            $('#par_'+inputbox.split('_')[1]).text(eval("parv_"+inputbox.split('_')[1]).value); 
        });
        $(inputbox).mouseup( function(){
            //$( slider ).slider( "option", "value", parseInt($(this).val()) );
            $( slider ).slider( "option", "value", ($(this).val()) );
            $('#par_'+inputbox.split('_')[1]).text(eval("parv_"+inputbox.split('_')[1]).value); 
        });
      }; 
      
      function setAllSliders(){
          let allSliders = $('[id^=slider_]'); 
          //console.log(allSliders);
          $.each(allSliders, function (i) {
            let paramName = $(allSliders[i]).attr('id').split('_')[1];  //odseparuje nazvy vsetkych premennych zo vsetkych sliderov v html kode, ktore zacinaju prefixom slider_
            setSlider("#slider_"+paramName,"#par_"+paramName+"_input");
          });
      }
      
                
    } );
    </script>