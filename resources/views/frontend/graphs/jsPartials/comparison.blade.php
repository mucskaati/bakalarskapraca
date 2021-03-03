<script src="{{ asset('js/jquery.ui.touch-punch.min.js') }}"></script>
<script>
    $( function() {
     //==================zvacsovanie thumbnailov=============================
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
      let lastChangeInSlider = true;
      
      
      var varsGraph = [
        @foreach($experiment->graphs as $graphKey => $graph)
            @foreach($graph->traces as $key => $trace)
             {'x': '{{ $trace->xaxis['id'] }}', 'y' : '{{ $trace->yaxis['id'] }}' },
            @endforeach
        @endforeach
      ]
      //var varsOrder = ["y", "u", "dor", "vf"];
      var schemesPlotNames = {
        @foreach($experiment->schemes as $scheme)
        {{ $scheme->prefix }}: {'name': '{{ $scheme->title }}', 'prefix' : '{{ $scheme->prefix }}', 'color': '{{ $scheme->trace_color }}', 'legendgroup': '{{ $scheme->legendgroup }}' },
        @endforeach
      }

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

       
      setAllSliders();
      var counter = 0;
      let paramsHistory = [];
      let paramsHistoryEnabled = false;

      //Nastavenie parametrov do objectu ktory sa bude posielat na server
      var parv_json = {
        @foreach ($experiment->schemes as $comparison)
          @foreach($comparison->sliders as $slider)
                "{{ $slider->title }}": parv_{{ $slider->title }}.value,
          @endforeach
        @endforeach

        @foreach($experiment->layout->sliders as $slider)
                "{{ $slider->title }}": parv_{{ $slider->title }}.value,
        @endforeach
             
      };

      // Zvolene schemy
      var what = [];
      //Prvy load po case aby sa nacitali parametre
      setTimeout(() => {
        runAjaxCall();
      }, 200)
      
  //----------------------------------------------- PDF --------------------------------------------------------------------------
  
  //-----------------------------------------------Export to PDF -----------------------------------------------------------
  @if($experiment->export)
  var image64 = "";   
  var pdfIcon = {
    'width': 500,
    'height': 600,
    'path': 'M181.9 256.1c-5-16-4.9-46.9-2-46.9 8.4 0 7.6 36.9 2 46.9zm-1.7 47.2c-7.7 20.2-17.3 43.3-28.4 62.7 18.3-7 39-17.2 62.9-21.9-12.7-9.6-24.9-23.4-34.5-40.8zM86.1 428.1c0 .8 13.2-5.4 34.9-40.2-6.7 6.3-29.1 24.5-34.9 40.2zM248 160h136v328c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V24C0 10.7 10.7 0 24 0h200v136c0 13.2 10.8 24 24 24zm-8 171.8c-20-12.2-33.3-29-42.7-53.8 4.5-18.5 11.6-46.6 6.2-64.2-4.7-29.4-42.4-26.5-47.8-6.8-5 18.3-.4 44.1 8.1 77-11.6 27.6-28.7 64.6-40.8 85.8-.1 0-.1.1-.2.1-27.1 13.9-73.6 44.5-54.5 68 5.6 6.9 16 10 21.5 10 17.9 0 35.7-18 61.1-61.8 25.8-8.5 54.1-19.1 79-23.2 21.7 11.8 47.1 19.5 64 19.5 29.2 0 31.2-32 19.7-43.4-13.9-13.6-54.3-9.7-73.6-7.2zM377 105L279 7c-4.5-4.5-10.6-7-17-7h-6v128h128v-6.1c0-6.3-2.5-12.4-7-16.9zm-74.1 255.3c4.1-2.7-2.5-11.9-42.8-9 37.1 15.8 42.8 9 42.8 9z'
  }
    
  function base64ToArrayBuffer(base64) {
      var binaryString = window.atob(base64);
      var binaryLen = binaryString.length;
      var bytes = new Uint8Array(binaryLen);
      for (var i = 0; i < binaryLen; i++) {
          var ascii = binaryString.charCodeAt(i);
          bytes[i] = ascii;
      }
      return bytes;
  }

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var newButton = {
      icon: pdfIcon,
      name: 'Export to PDF',
      click: function(gd) {   
      $.post('{{ route("export.comparison") }}', {
        params: {
        @foreach($experiment->layout->sliders as $slider)
        "{{ $slider->title }}":  (parv_{{ $slider->title }}.value != parv_{{ $slider->title }}_input.value && !lastChangeInSlider) ? parv_{{ $slider->title }}_input.value : parv_{{ $slider->title }}.value,
        @endforeach    
        @foreach ($experiment->schemes as $comparison)
          @foreach($comparison->sliders as $slider)
          "{{ $slider->title }}":  (parv_{{ $slider->title }}.value != parv_{{ $slider->title }}_input.value && !lastChangeInSlider) ? parv_{{ $slider->title }}_input.value : parv_{{ $slider->title }}.value,
          @endforeach
        @endforeach    
        },
        history: paramsHistory,
        schemes: what,
        experiment_id: {{ $experiment->id }}, 
      imgResult: image64,
    },{responseType:'arraybuffer'})
      .done(function (response) {
           var arrrayBuffer = base64ToArrayBuffer(response);
           var file = new Blob([arrrayBuffer], {type: 'application/pdf'});
           var fileURL = URL.createObjectURL(file);
           window.open(fileURL);
      });  
      }
  }  
  @endif 
  //-------------------------------------------------------- Ajax call ----------------------------------------------------------
      function runAjaxCall() { 
      $.ajax({
        type: "GET",
        url: "http://apps.iolab.sk:9000/symetry2",
        data: {
          what: '['+what.toString()+']',
          ...parv_json
        },
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

          toggleHideFieldsets();
        },
        success:function(data)   
        {

          //Pridavanie do historie porovnania
          addComparison();
          addComparisonToHTML(counter)

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

          //Vytvorenie stop na graph      
          $.each( tasks, function( keyt, valuet ) {
              $.each( vars, function( keyv, valuev ) {
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
                      color: (schemesPlotNames[valuet]['color'] && counter == 0) ? schemesPlotNames[valuet]['color'] : colors[k + counter],
                      line: {color: 'transparent'}
                  },  
                  legendgroup: schemesPlotNames[valuet]['legendgroup'] + k + counter, 
                  showlegend: false, 
                  name: schemesPlotNames[valuet]['name']+ " - Comparison " + (counter+1)
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
          });
         
          //Ak je povolena hsitoria pridaj cestu ak nie vytvor graph nanovo
          if ($('#checkbox_comparisons').is(":checked") && counter>0) 
              { Plotly.addTraces($('#plotdiv')[0], plotarray).then((gd) => { return Plotly.toImage(gd); })
                .then((dataURI) => { //console.log(dataURI); 
                                      image64 = dataURI;
                                      //console.log(image64);
                                      }); }
          else
              { Plotly.newPlot($('#plotdiv')[0], plotarray, layout, {displaylogo: false, responsive: true, modeBarButtonsToAdd: [newButton]}).then((gd) => { return Plotly.toImage(gd); })
                .then((dataURI) => { //console.log(dataURI); 
                                      image64 = dataURI;
                                      //console.log(image64);
                                      }); }

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
          let paramName = idPar.substring(5);
          //Zmen hodnotu len v pripade ze zmena nastala v slajdri
          if(lastChangeInSlider) {
            parv_json[paramName] = ui.value
          }
          // Dependencies na slajdri
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
          what.push('{{ $comparison->prefix }}');
          console.log(what);
          @endif

          //Na klik zisti ci je checkboxradio zaceknuty
          $( "#choice_{{ $comparison->prefix }}").on('click', (e) => {
            if(!$( "#choice_label_{{ $comparison->prefix }}" ).hasClass('ui-checkboxradio-checked'))
            {
              $('.div_params_{{ $comparison->prefix }}').show();
              $('.div_checkbox_{{ $comparison->prefix }}').show();
              what.push('{{ $comparison->prefix }}');
            } else {
              $('.div_params_{{ $comparison->prefix }}').hide();
              $('.div_checkbox_{{ $comparison->prefix }}').hide();
              what = what.filter(function(scheme){ return scheme != '{{ $comparison->prefix }}'; })
              
            }
          })
          @endforeach

         $( "#div_radio" ).controlgroup();
      } );  


//----------------------------------------------- Examples -----------------------------------------------------------

@foreach($experiment->examples as $example)
    $( "#radio_demo{{ $example->id }}" ).on( "click", handleDemo{{ $example->id }} );
    
    function handleDemo{{ $example->id }}() { 
      @foreach($example->sliders as $slider)
        parv_{{ $slider->title }}.value = {{ $slider->pivot->value }}; changeSlider("parv_{{ $slider->title }}");
      @endforeach

      @if($example->schemes->count() > 0)
      what = [];

      //--------------------------Odznacim vsetky schemy--------------------
      @foreach($experiment->schemes as $schem)
      $( '#choice_{{ $schem->prefix }}' ).prop( "checked", false).checkboxradio('refresh');
      $('.div_params_{{ $schem->prefix }}').hide();
      @endforeach
       //--------------------------Koniec Odznacim vsetky schemy--------------------

      @foreach($example->schemes as $scheme) 
        @if($scheme->pivot->checked)
        $( '#choice_{{ $scheme->prefix }}' ).prop( "checked", true).checkboxradio('refresh');  
        what.push('{{ $scheme->prefix }}')
        $('.div_params_{{ $scheme->prefix }}').show();
       
        @else 
        $( '#choice_{{ $scheme->prefix }}' ).prop( "checked", false).checkboxradio('refresh'); 
        what = what.filter(function(scheme){ return scheme != '{{ $comparison->prefix }}'; }) 
        $('.div_params_{{ $scheme->prefix }}').hide();
        @endif
      @endforeach
      @endif

      @foreach($example->checkboxes as $checkbox)
        @if(!$checkbox->pivot->checked)
        //-------- Pripad ked chechbox v priklade NEchceme zaskrtnut
        if ($('#checkbox_{{ $checkbox->attribute_name }}').is(":checked")) { 
            // Zmen aj zavisle slajdre na checkboxe predtym ako odskrtneme checkbox
            @if($checkbox->slider_dependency_change)
              if ( $("#checkbox_{{ $checkbox->attribute_name }}").prop("checked") )
              { 
                @foreach($checkbox->dependentSliders as $slider)
                parv_{{ $slider->title }}.value =  {{ ($slider->default_function) ? $slider->default_function : $slider->default }};
                $('#par_{{ $slider->title }}').text(round(parv_{{ $slider->title }}.value,3)); 
                $( "#slider_{{ $slider->title }}" ).slider( "value", parv_{{ $slider->title }}.value );
                changeSliderAndInput("parv_{{ $slider->title }}");
                @endforeach
              } 
            @endif
            $( '#checkbox_{{ $checkbox->attribute_name }}' ).prop("checked", false).checkboxradio('refresh');
        }
        @else 
            // -------- Pripad ked chechbox v priklade chceme zaskrtnut
            if (!$('#checkbox_{{ $checkbox->attribute_name }}').is(":checked")) {
            $("#div_sats").toggle();
            $( '#checkbox_{{ $checkbox->attribute_name }}' ).prop( "checked", true).checkboxradio('refresh'); 

            // Zmen aj zavisle slajdre na checkboxe 
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
        }
        @endif
      @endforeach
      runAjaxCall()  
    }  
@endforeach  
//----------------------------------------------- Checkboxes ---------------------------------------------------------
  
$( function() {
    $( "input[type=checkbox]" ).checkboxradio({});
});

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

  $("#checkbox_comparisons").click(function(){
       toggleParamsHistory();
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
      parv_json[whatPart] = eval(what).value;
     }
     
     function changeSliderAndInput(what) {
       let whatPart = what.substring(5);
       $('#par_'+whatPart).text(eval(what).value); 
       $( "#slider_"+whatPart ).slider( "value", eval(what).value );
       $('#par_'+whatPart+'_input').val(eval(what).value);
       parv_json[whatPart] = eval(what).value;
     }
     
     function setSlider(slider,inputbox, paramName) {
    //nastavi slider podla ciselneho vstupu a zaroven nastavi krok ciselneho vstupu
    $(inputbox).attr('step', eval("parv_"+inputbox.split('_')[1]).step); 
      $(inputbox).keyup( function(){
        lastChangeInSlider = true;
          $( slider ).slider( "option", "value", ($(this).val()) );
          $('#par_'+inputbox.split('_')[1]).text(eval("parv_"+inputbox.split('_')[1]).value); 
          //Nastav hodnotu do premennej parv_ID_input po vpisani hodnoty do textboxu 
          //a to v tom pripade len ked hodnota slajdra a textboxu sa lisi
            if(parseFloat($(inputbox).val()) != eval("parv_"+inputbox.split('_')[1]).value) {
              eval("parv_"+inputbox.split('_')[1]+'_input').value = parseFloat($(this).val())   
              lastChangeInSlider = false;  // Posledna zmena nastala v inpute preto ber hodnoty z inputu
              parv_json[paramName] = parseFloat($(this).val());
            }
          //Pockam kym sa nastavia slajdre az potom pustim ajax
          setTimeout(() => { runAjaxCall() }, 200);
      });

    };
      
      function setAllSliders(){
          let allSliders = $('[id^=slider_]'); 
          //console.log(allSliders);
          $.each(allSliders, function (i) {
            let paramName = $(allSliders[i]).attr('id').split('_')[1];  //odseparuje nazvy vsetkych premennych zo vsetkych sliderov v html kode, ktore zacinaju prefixom slider_
            setSlider("#slider_"+paramName,"#par_"+paramName+"_input", paramName);
          });
      }

      function addComparisonToHTML(counter) {
        //Pridaj comparison popup
        if(counter >= 0)
        {
          let comparison = $(".comparisons");
          comparison.empty();
          for(let i = 0; i <= counter; i++) {
            let content = `<b>Comparison paremeters:</b><br><br>`;
            Object.entries(paramsHistory[i]).forEach(([key, value]) => {
              if(key != 'id') {
              content += `<b>${key+1}</b>: ${value},  `
              }
            });
            let html = `<button id="comparison_params" class="btn btn-primary col-6 col-md-2" data-container="body" data-toggle="popover" data-placement="bottom" 
            title="${content}">
                            Comparison ${i+1}
                        </button>`;
          comparison.append(html);
          
          $('[data-toggle="popover"]').tooltip({
            content: function () {
                return $(this).prop('title');
            }
          });


          }
        }
      }

      function addComparison()
      {
        if ($('#checkbox_comparisons').is(":checked")) 
              { counter++; 
                paramsHistoryEnabled = true;
                paramsHistory.push({
                  id:counter,
                  ...parv_json
                })
              }

          else
              { 
                counter = 0;
                paramsHistoryEnabled = false;
                paramsHistory = [];
                paramsHistory.push({
                  id:counter,
                  ...parv_json
                })
              }
      }

      function toggleHideFieldsets()
      {

        if(paramsHistoryEnabled)
           {
            $("#div_radio" ).addClass( "elementDisabled" );
            $(".schemes").addClass( "elementDisabled" );
            $('.comparisons').show();
           } else {
            $( "#div_radio" ).removeClass( "elementDisabled" );
            $( ".schemes" ).removeClass( "elementDisabled" );
            $('.comparisons').hide();
           }
      }

      function toggleParamsHistory()
      {
        paramsHistoryEnabled = !paramsHistoryEnabled;
        toggleHideFieldsets();
      }         
    } );
    </script>