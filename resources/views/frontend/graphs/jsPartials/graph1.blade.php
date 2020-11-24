<script src="{{ asset('js/jquery.ui.touch-punch.min.js') }}"></script>
<script>
    $( function() {
//---------------------------------------------------Layout---------------------------------------------------------------
      var layout = {
              grid: {rows: {{ $experiment->layout->rows }}, columns: {{ $experiment->layout->columns }} },
              height: {{ $experiment->layout->height }},
              margin: {{ $experiment->layout->margin }},
              xaxis: {{ $experiment->layout->xaxis }},
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

  
 //------------------------------------------Sliders initi -----------------------------------------------------------------     
     @foreach($experiment->layout->sliders as $slider)
      var parv_{{ $slider->title }} = { value: {{ ($slider->default_function) ?: $slider->default  }} };
     @endforeach
    
  
      @foreach($experiment->layout->sliders as $slider)
      createSlider("#slider_{{ $slider->title }}", "#par_{{ $slider->title }}", {{ $slider->min }}, {{ $slider->max }}, parv_{{ $slider->title }}, {{ $slider->step }});
      @endforeach     
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
        @foreach($experiment->layout->sliders as $slider)
          "parv_{{ $slider->title }}": parv_{{ $slider->title }}.value,   
        @endforeach     
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
          "{{ $slider->title }}":parv_{{ $slider->title }}.value,
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
          @foreach($experiment->graphs as $graphKey => $graph)
            @foreach($graph->traces as $key => $trace)
            let trace{{ $trace->id }} = {
              x: data.{{ $trace->xaxis['id'] }}.split(","),
              y: data.{{ $trace->yaxis['id'] }}.split(","),   
              marker: {
                  color: '{{ $trace->color }}',
                  line: {color: 'transparent'}
              },  
              legendgroup: '{{ $trace->legendgroup }}',   
              showlegend: {{ ($trace->show_legend) ? 'true' : 'false' }},
              @if($graphKey > 0)
              xaxis: 'x{{ $graphKey+1 }}',
              yaxis: 'y{{ $graphKey+1 }}', 
              @endif
              name: '{{ $trace->title }}'};  
            @endforeach
          @endforeach
         
          @if($experiment->export)
          Plotly.newPlot($('#plotdiv')[0], 
          [
            @foreach($experiment->graphs as $graphKey => $graph)
              @foreach($graph->traces as $key => $trace)
              trace{{ $trace->id }},
              @endforeach
            @endforeach
          ], layout, {displaylogo: false, responsive: true, modeBarButtonsToAdd: [newButton]})
                .then((gd) => { return Plotly.toImage(gd); })
                .then((dataURI) => { //console.log(dataURI); 
                                      image64 = dataURI;
                                      //console.log(image64);
                                      });
            @else 
            Plotly.newPlot($('#plotdiv')[0], [
              @foreach($experiment->graphs as $graphKey => $graph)
                @foreach($graph->traces as $key => $trace)
                  trace{{ $trace->id }},
                @endforeach
              @endforeach
            ], layout, {displaylogo: false, responsive: true});
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
          //runAjaxCall()
        },
        slide: function( event, ui ) {
          iddPar.text( ui.value );
        },
        change: function(event, ui) { 
          defaultValue.value = ui.value; 
          @foreach($experiment->layout->sliders as $slider)  
          if ( idPar == "#par_{{ $slider->title }}") {
                @foreach($slider->dependencies as $dependency)
                
                 parv_{{ $dependency->title }}.value =  {{ ($dependency->pivot->value_same_as_added) ? 'parv_'.$slider->title.'.value' : $dependency->pivot->value_function }};
                $('#par_{{ $dependency->title }}').text(round(parv_{{ $dependency->title }}.value,3)); 
                $( "#slider_{{ $dependency->title }}" ).slider( "value", parv_{{ $dependency->title }}.value ); 
                @endforeach
          }
          @endforeach
          runAjaxCall()
        },
      }); 
      };

//----------------------------------------------- Checkboxes ---------------------------------------------------------
  
$( function() {
        $( "input" ).checkboxradio({   
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
        @endforeach
      } 
      else {
        @foreach($checkbox->dependentSliders as $slider)
        parv_{{ $slider->title }}.value =  {{ ($slider->default_function) ?: $slider->default }};
        $('#par_{{ $slider->title }}').text(round(parv_{{ $slider->title }}.value,3)); 
        $( "#slider_{{ $slider->title }}" ).slider( "value", parv_{{ $slider->title }}.value );
        @endforeach        
      }
      runAjaxCall()
    } 
    
  $(".toggle{{ $checkbox->id }}").click(function(){
    $("#div_{{ $checkbox->attribute_name }}").toggle();
  });  
  @endforeach

//----------------------------------------------------Functions----------------------------------------------------------
      
    function round(value, decimals) {
      return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
    }
      
    function KPGain(Km,am,Tc) {           //feedforward loop controller gain
      return (1/Tc-am)/Km;
    }; 

    function KcGain(Km,am,Tc) {           //stabilizing controller gain
      return (1/Tc-am)/Km;
    };
    
    function bGain(am,Tf) {              //derivative time constant of PD control 
      return 2*Tf-am*Tf*Tf;
    };
                     
    });
</script>