import Axios from "axios";
import AppForm from "../app-components/Form/AppForm";
import Loading from "vue-loading-overlay";
import ToggleTemplate from "../mixins/ToggleTemplateMixin";
// import highlighting library (you can use any library you want just return html string)

// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
import { PrismEditor } from "vue-prism-editor";
import "vue-prism-editor/dist/prismeditor.min.css"; // import the styles somewhere

import { highlight, languages } from "prismjs/components/prism-core";
import "prismjs/components/prism-clike";
import "prismjs/components/prism-javascript";
import "prismjs/themes/prism-tomorrow.css"; // import syntax highlighting styles

Vue.component("experiment-form", {
    mixins: [AppForm, ToggleTemplate],
    props: ["update"],
    components: { Loading, PrismEditor },
    data: function() {
        return {
            form: {
                ajax_url: "http://apps.iolab.sk:9000/symetry1b",
                description: "",
                export: false,
                layout: "",
                slug: "",
                type: "fo",
                title: "",
                custom_js: "",
                template: `
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
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Single experiments</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              @foreach ($fos as $fo)
              <a class="dropdown-item" href="{{ route('graph_fo', ['id' => $fo->id, 'slug' => $fo->slug]) }}">{{ $fo->title }}</a>
              @endforeach
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Path based experiments</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              @foreach ($nyquist as $nyq)
              <a class="dropdown-item" href="{{ route('graph_nyquist', ['id' => $nyq->id, 'slug' => $nyq->slug]) }}">{{ $nyq->title }}</a>
              @endforeach
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Comparisons</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              @foreach ($comparisons as $comparison)
              <a class="dropdown-item" href="{{ route('comparison', ['id' => $comparison->id, 'slug' => $comparison->slug]) }}">{{ $comparison->title }}</a>
              @endforeach
            </div>
          </li>
        </ul>
      </div>
      </div>
  </nav>
</header>
{{--  --------------------------------  End Header  --------------------------------------------------------- --}}
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
{{--  --------------------------------  Koniec buttonov --------------------------------------------------------- --}}
    <div class="row"> 
{{-- ------------------------ Slajdre a checkboxy ----------------------------------------------- --}}
            <div class="col-xs-12 col-sm-4 col-lg-4"> 
            <fieldset> 
              <div class="row">       
                @foreach ($experiment->layout->sliders()->doesntHave('dependentCheckboxes')->where('visible',1)->orderBy('sorting')->get() as $slider)
                <div class="col-12 col-md-{{ $slider->columns }} mb-4 slider-roller">
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
              <div class="col-12 col-md-{{ $slider->columns }} mb-5 slider-roller">
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
</footer>`,
                graphs: [],
                custom_js: `
<script>
// Defined functions ready to use:
// round(value, decimals)
// KPGain(Km,am,Tc)
// KcGain(Km,am,Tc)
// bGain(am,Tf)
// Your definitions of functions
</script>
                `
            },
            responses: [],
            show_third_step: false,
            isLoading: false,
            mediaWysiwygConfig2: {
                btns: [["fullscreen", "viewHTML"]]
            }
        };
    },
    mounted() {
        if (this.update) {
            this.getResponsesFromServer();
        }
    },
    methods: {
        highlighter(code) {
            return highlight(code, languages.js); //returns html
        },
        getResponsesFromServer() {
            let th = this;
            if (!this.form.ajax_url) {
                return;
            }
            th.isLoading = true;
            axios
                .get(this.form.ajax_url)
                .then(function(response) {
                    let keys = collect(Object.keys(response.data));
                    keys = keys.map(item => {
                        return { id: item, title: item };
                    });
                    th.responses = keys.items;
                    th.show_third_step = true;
                    th.isLoading = false;
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    this.isLoading = false;
                })
                .then(function() {
                    // always executed
                });
        },

        getCountOfGraphs() {
            const graphs = this.form.layout.columns * this.form.layout.rows;
            this.addGraphs(graphs);
        },
        addGraphs(graphs) {
            this.form.graphs = [];
            for (let i = 0; i < graphs; i++) {
                this.form.graphs.push({
                    id: this.form.graphs.length,
                    annotation_title: "",
                    align: "left",
                    annotation_angle: "",
                    xaxis: "",
                    yaxis: "",
                    traces: []
                });
            }
        },

        addTraceToGraph(index) {
            console.log(index);
            this.form.graphs[index].traces.push({
                id: this.form.graphs[index].traces.length,
                title: this.form.graphs[index].annotation_title,
                xaxis: "",
                yaxis: "",
                color: "",
                legendgroup: "",
                show_legend: true
            });
        },
        deleteTraceFromGraph: function(index, traceIndex) {
            this.form.graphs[index].traces.splice(traceIndex, 1);
        }
    }
});
