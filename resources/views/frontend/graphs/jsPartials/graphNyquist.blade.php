<script src="{{ asset('js/jquery.ui.touch-punch.min.js') }}"></script>
<script type='text/x-mathjax-config'>MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']], processEscapes: true}});</script>
<script type='text/javascript' src='//cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/MathJax.js?config=TeX-AMS-MML_HTMLorMML%2CSafe.js&#038;ver=4.1'></script>
<script>
    $( function() {
      let changeCounter = 0;  
      let lastChangeInSlider = true;
//---------------------------------------------------Layout---------------------------------------------------------------
 
var layout = {
              grid: {rows: {{ $experiment->layout->rows }}, columns: {{ $experiment->layout->columns }} },
              margin: {{ $experiment->layout->margin }},
              showlegend: true,
              hovermode: false,
              shapes: [
            @foreach($experiment->paths as $path)    
            {
            type: 'path',
            path: '',
            visible: 'true',
            line: {
              color: '{{ $path->legend_color }}'
            }
            },
            {
              type: 'path',
              path: '',
              visible: 'true',
              line: {
                color: '{{ $path->legend_color }}',
                dash: 'dashdot'
              }
            },
            @endforeach
        ]
      };

  
 //------------------------------------------Sliders initi -----------------------------------------------------------------     
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
      setSlider("#slider_{{ $slider->title }}","#par_{{ $slider->title }}_input");
      //Delay 100 stotin kym sa nastavia hodnoty a potom az pustime ajax call po doslajdovani
      //Riesi to problem s milion requestmi na server
      @if(!$experiment->run_button)
            $("#slider_{{ $slider->title }}").on( "slidestop", function( event, ui ) {
                setTimeout(() => { runAjaxCall() }, 100);
            });
      @endif
      @endforeach

      //Prvotny ajax call po loadnuti stranky
      runAjaxCall()
  
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
      $.post('{{ route("export") }}', {
        params: {
        @foreach($experiment->layout->sliders as $slider)
        "{{ $slider->title }}":  (parv_{{ $slider->title }}.value != parv_{{ $slider->title }}_input.value && !lastChangeInSlider) ? parv_{{ $slider->title }}_input.value : parv_{{ $slider->title }}.value,
        @endforeach    
        },
        experiment_id: {{ $experiment->id }}, 
      "imgResult": image64,
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
  //---------------------------------------------------------------------Ajax Call ---------------------------------------------
     
  function runAjaxCall() { 

      $.ajax({
        type: "GET",
        url: "{{ $experiment->ajax_url }}",
        data: {
          @foreach($experiment->layout->sliders as $slider)
          "{{ $slider->title }}":  (parv_{{ $slider->title }}.value != parv_{{ $slider->title }}_input.value && !lastChangeInSlider) ? parv_{{ $slider->title }}_input.value : parv_{{ $slider->title }}.value,
          @endforeach
        },
        dataType: 'json',
        beforeSend: function() {
          $('#loader').show();
          $( "fieldset" ).addClass( "elementDisabled" );
        },
        complete: function(){
          $('#loader').hide();
          $( "fieldset" ).removeClass( "elementDisabled" );
        },
        success:function(data)   
        { 
          changeCounter = 0;
          let pathCounter = -1;
          let traces = [];
          @foreach($experiment->paths as $key => $path)
            layout.shapes[pathCounter + 1].path = getPath(data.{{ $path->path1["id"] }}.split(","), data.{{ $path->path2["id"] }}.split(","))[0];
            layout.shapes[pathCounter + 2].path = getPath(data.{{ $path->path1["id"] }}.split(","), data.{{ $path->path2["id"] }}.split(","))[1];
            
            traces.push({
              x: [0],
              y: [0],
              type: 'line',
              marker: {
                color: '{{ $path->legend_color }}',
                line: {
                  color: 'transparent'
                }
              },
              legendgroup: 'path{{ $path->id }}',
              name: '{!! $path->path1_name !!}'
            });
            traces.push({
              x: [0],
              y: [0],
              type: 'line',
              marker: {
                color: '{{ $path->legend_color }}',
                line: {
                  color: 'transparent'
                }
              },
              legendgroup: 'path{{ $path->id }}',
              showlegend: {{ ($path->show_legend) ? 'true' : 'false' }},
              name: '{!! $path->path2_name !!}'
            }); 
            pathCounter += 2;
          @endforeach

          console.log(layout.shapes);
         
          @if($experiment->export)
          Plotly.newPlot($('#plotdiv')[0], traces, layout, {
              displaylogo: false,
              responsive: true,
              modeBarButtonsToRemove: ['hoverClosestCartesian', 'hoverCompareCartesian'],
              modeBarButtonsToAdd: [newButton]
            }) .then((gd) => { return Plotly.toImage(gd); })
                .then((dataURI) => { //console.log(dataURI); 
                                      image64 = dataURI;
                                      //console.log(image64);
                                      });
            $('#plotdiv')[0].on('plotly_legendclick', function(data) {
              let shapeIndex = data.curveNumber;
              let opacity = eval(data.node.getAttribute("style").split(";")[0].split(":")[1]);
              //console.log(shapeIndex);
              if (opacity < 1) {
                layout.shapes[shapeIndex].visible = true;
                layout.shapes[shapeIndex + 1].visible = true;
              } else {
                layout.shapes[shapeIndex].visible = false;
                layout.shapes[shapeIndex + 1].visible = false;
              }

            });
          @else 
          Plotly.newPlot($('#plotdiv')[0], traces, layout, {
              displaylogo: false,
              responsive: true,
              modeBarButtonsToRemove: ['hoverClosestCartesian', 'hoverCompareCartesian']
            });
            $('#plotdiv')[0].on('plotly_legendclick', function(data) {
              let shapeIndex = data.curveNumber;
              let opacity = eval(data.node.getAttribute("style").split(";")[0].split(":")[1]);
              //console.log(shapeIndex);
              if (opacity < 1) {
                layout.shapes[shapeIndex].visible = true;
                layout.shapes[shapeIndex + 1].visible = true;
              } else {
                layout.shapes[shapeIndex].visible = false;
                layout.shapes[shapeIndex + 1].visible = false;
              }

            });
          @endif
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
          @foreach($experiment->layout->sliders()->whereHas('dependencies')->get() as $slider)  
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
         
        },
      }); 
      };

//----------------------------------------------- Checkboxes ---------------------------------------------------------
  
$( function() {
        $( "input[type=checkbox]" ).checkboxradio({   
            //icon: false    
            //label: "custom label"
        });
    } );

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
      @if(!$experiment->run_button)
      runAjaxCall()
      @endif
    } 
    
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

//----------------------------------------------------Functions----------------------------------------------------------
      
    function round(value, decimals) {
      return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
    }

    function KPGain(Km, am, Tm) { //feedforward loop controller gain
      return Math.exp(-1 - am * Tm) / Km / Tm;
    };

    function KcGain(Km, am, Tm) { //stabilizing controller gain
      return Math.exp(-1 - am * Tm) / Km / Tm;
    };

    function bGain(am, Tm, Tf) { //derivative time constant of PD control 
      return (1 - (1 - am * Tf) * (1 - am * Tf) * Math.exp(-Tm * am)) / am;
    };

    function setSlider(slider,inputbox) {
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
              lastChangeInSlider = false;
            }
          //Pockam kym sa nastavia slajdre az potom pustim ajax
          setTimeout(() => { runAjaxCall() }, 200);
      });

    };

  function changeSliderAndInput(what) {
     let whatPart = what.substring(5);
     $('#par_'+whatPart).text(eval(what).value); 
     $( "#slider_"+whatPart ).slider( "value", eval(what).value );
     $('#par_'+whatPart+'_input').val(eval(what).value);
   }

   function getPath(arr1, arr2) {
        let myPath1 = "M " + arr1[0] + "," + arr2[0];
        let myPath2 = "";
        if (arr2[0].charAt(0) == "-") {
          myPath2 = myPath2 + "M " + arr1[0] + "," + arr2[0].replace(/^-/, '');
        } else {
          myPath2 = myPath2 + "M " + arr1[0] + ",-" + arr2[0];
        }

        for (let i = 0, len = arr1.length; i < len; i++) {
          myPath1 = myPath1 + " L " + arr1[i] + "," + arr2[i];
          if (arr2[i].charAt(0) == "-") {
            myPath2 = myPath2 + " L " + arr1[i] + "," + arr2[i].replace(/^-/, '');
          } else {
            myPath2 = myPath2 + " L " + arr1[i] + ",-" + arr2[i];
          }
        }                                              
        return [myPath1, myPath2];
      }
                     
    });
</script>