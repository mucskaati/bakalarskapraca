<script>
    $( function() {
      
      var image64 = "";    
      var layout = {
              //https://plotly.com/javascript/subplots/
              //https://stackoverflow.com/questions/31526045/remove-space-between-subplots-in-plotly
              //grid: {rows: 5, columns: 1, pattern: 'independent'},
              grid: {rows: 2, columns: 1},
              height: 400,
              margin: {l: 60, r: 20, b: 30, t: 30, pad: 4},
              xaxis: {domain: [0, 1]},
              //legend: {
      //x: 1,
     // y: 0.5
   // },
              //https://plotly.com/javascript/text-and-annotations/#subplot-annotations
              annotations: [
              { text: "y(t)",
                font: { size: 14,
                        color: 'black', },
                textangle: 270, 
                showarrow: false,
                align: 'left',
                x: -0.1, //position in x domain
                y: 0.8, //position in y domain
                xref: 'paper',
                yref: 'paper',
              },
              { text: "u(t)",
                font: { size: 14,
                        color: 'black', },
                textangle: 270, 
                showarrow: false,
                align: 'center',
                //x: 0, //position in x domain
                x: -.1,
                y: 0.2,  // position in y domain
                xref: 'paper',
                yref: 'paper',
                //sizex: 100, 
                //xanchor: 'left',
                //xsizemode: 'pixel',
              },           
              ]
      };
  
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
  
      
      var parv_tsim = { value: 10 };
      var parv_Ts = { value: 0.01 };     
  //    var parv_Ts = { value: parv_tsim.value/200 };            
      var parv_tw = { value: 1 };
      var parv_w = { value: 1 };  
      var parv_Ks = { value: 1 };         
      var parv_Ksm = { value: 1 };
      var parv_a = { value: 0 };         
      var parv_am = { value: 0 };    
      var parv_Tc = { value: 0.5 };
      var parv_KP = { value: KPGain(parv_Ksm.value,parv_am.value,parv_Tc.value) };
      //console.log(parv_KP);
      var parv_Umin = { value: 0 };         
      var parv_Umax = { value: 0.2 };
    
  
        
      createSlider("#slider_tsim", "#par_tsim", 0, 100, parv_tsim, 1);
  //    createSlider("#slider_Ts", "#par_Ts", 0, 1, parv_Ts, .001);
      createSlider("#slider_tw", "#par_tw", 0, 100, parv_tw, 10);
      createSlider("#slider_w", "#par_w", 0, 5, parv_w, 0.1);
      createSlider("#slider_Ks", "#par_Ks", 0.1, 5, parv_Ks, 0.1);
      createSlider("#slider_Ksm", "#par_Ksm", 0.1, 5, parv_Ksm, 0.1);
      createSlider("#slider_a", "#par_a", -2, 5, parv_a, 0.1);
      createSlider("#slider_am", "#par_am", -2, 5, parv_am, 0.1);    
      createSlider("#slider_KP", "#par_KP", 0, 5, parv_KP, 0.01);
      createSlider("#slider_Tc", "#par_Tc", 0.01, 5, parv_Tc, 0.01);
      createSlider("#slider_Umin", "#par_Umin", -3, 1, parv_Umin, 0.01);
      createSlider("#slider_Umax", "#par_Umax", -1, 3, parv_Umax, 0.01);      
      runAjaxCall()
  
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
  
  var newButton = {
      icon: pdfIcon,
      name: 'Export to PDF',
      click: function(gd) {   
      $.post('pdf_FO.php', {
      "parv_w": parv_w.value,    
      "parv_Ks": parv_Ks.value,
      "parv_Ksm": parv_Ksm.value,
      "parv_a": parv_a.value,
      "parv_am": parv_am.value,  
      "parv_KP": parv_KP.value,
      "parv_Tc": parv_Tc.value,
      "parv_Umin": parv_Umin.value,
      "parv_Umax": parv_Umax.value,       
      "imgResult": image64,
    },{responseType:'arraybuffer'})
      .success(function (response) {
      //console.log(image64);
           var arrrayBuffer = base64ToArrayBuffer(response);
           var file = new Blob([arrrayBuffer], {type: 'application/pdf'});
           var fileURL = URL.createObjectURL(file);
           window.open(fileURL);
      });  
      }
  }    
      
      function runAjaxCall() { 
      $.ajax({
        type: "GET",
        url: "http://apps.iolab.sk:9000/symetry10",
        data: {"tsim":parv_tsim.value,"Ts":parv_Ts.value,"tw":parv_tw.value,"w":parv_w.value,"Ks":parv_Ks.value,"Ksm":parv_Ksm.value,"a":parv_a.value,"am":parv_am.value,"KP":parv_KP.value,"Tc":parv_Tc.value,"Umin":parv_Umin.value,"Umax":parv_Umax.value},
        //"Td":parv_Td.value,"Tdm":parv_Tdm.value,
        //"Umin":parv_Umin.value,"Umax":parv_Umax.value,"Uifmin":parv_Uifmin.value,"Uifmax":parv_Uifmax.value,
        //data: {"vi":parv_vi},
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
        { t = data.t.split(",");
          u = data.u.split(",");
          y = data.y.split(",");
          us = data.us.split(",");
          ys = data.ys.split(",");
          let trace1 = {
              x: t,
              y: y, 
              //yaxis:{title: 'Value B'},            
              marker: {
                  color: '#ff7f0e',
                  line: {color: 'transparent'}
              },  
              legendgroup: 'a',   
              //https://plotly.com/javascript/legend/#grouped-legend   
             // showlegend: false,
              name: 'closed loop'};  
          let trace2 = {
              x: t,
              y: u,
              xaxis: 'x2',
              yaxis: 'y2',             
              marker: {
                  color: '#ff7f0e',
                  line: {color: 'transparent'}
              },
              legendgroup: 'a',
              showlegend: false,
              name: 'closed loop'};    
          let trace3 = {
              x: t,
              y: ys,           
              marker: {
                  color: '#2ca02c',
                  line: {color: 'transparent'}
              },
              legendgroup: 'b',      
              //showlegend: false,
              name: 'open loop'};  
          let trace4 = {
              x: t,
              y: us,
              xaxis: 'x2',
              yaxis: 'y2',
              marker: {
                  color: '#2ca02c',
                  line: {color: 'transparent'}
              },
              legendgroup: 'b',       
              showlegend: false, 
              name: 'open loop'};
          Plotly.newPlot($('#plotdiv')[0], [trace1,trace2,trace3,trace4], layout, {displaylogo: false, responsive: true, modeBarButtonsToAdd: [newButton]})
                .then((gd) => { return Plotly.toImage(gd); })
                .then((dataURI) => { //console.log(dataURI); 
                                      image64 = dataURI;
                                      //console.log(image64);
                                      });
        }     
      }).done(function( o ) {
         // do something                                                                     
      }); 
      }    
  
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
          if ( idPar == "#par_Ksm")
              { parv_KP.value =  KPGain(parv_Ksm.value,parv_am.value,parv_Tc.value);
                $('#par_KP').text(round(parv_KP.value,3)); 
                $( "#slider_KP" ).slider( "value", parv_KP.value ); }
          if ( idPar == "#par_am")
              { parv_KP.value =  KPGain(parv_Ksm.value,parv_am.value,parv_Tc.value);
                $('#par_KP').text(round(parv_KP.value,3)); 
                $( "#slider_KP" ).slider( "value", parv_KP.value ); }
          if ( idPar == "#par_Tc")
              { parv_KP.value =  KPGain(parv_Ksm.value,parv_am.value,parv_Tc.value);
                $('#par_KP').text(round(parv_KP.value,3)); 
                $( "#slider_KP" ).slider( "value", parv_KP.value ); }
          if ( idPar == "#par_Ks")
              { parv_Ksm.value = parv_Ks.value;
                $('#par_Ksm').text(parv_Ksm.value); 
                $( "#slider_Ksm" ).slider( "value", parv_Ksm.value );
                parv_KP.value =  KPGain(parv_Ksm.value,parv_am.value,parv_Tc.value);
                $('#par_KP').text(round(parv_KP.value,3)); 
                $( "#slider_KP" ).slider( "value", parv_KP.value ); }
          if ( idPar == "#par_a" )
              { parv_am.value = parv_a.value;
                $('#par_am').text(parv_am.value); 
                $( "#slider_am" ).slider( "value", parv_am.value );
                parv_KP.value =  KPGain(parv_Ksm.value,parv_am.value,parv_Tc.value);
                $('#par_KP').text(round(parv_KP.value,3)); 
                $( "#slider_KP" ).slider( "value", parv_KP.value ); }
          runAjaxCall()
        },
      }); 
      };
      
      function round(value, decimals) {
        return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
      }
      
      function KPGain(Km,am,Tc) {           //feedforward loop controller gain
          return (1/Tc-am)/Km;
      }; 
                     
    } );
    </script>