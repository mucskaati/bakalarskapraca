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

Vue.component("comparison-form", {
    mixins: [AppForm, ToggleTemplate],
    props: ["update"],
    components: { Loading, PrismEditor },
    data: function() {
        return {
            form: {
                ajax_url: "http://apps.iolab.sk:9000/symetry2",
                description: "",
                export: false,
                layout: "",
                slug: "",
                type: "comparison",
                title: "",
                custom_js: "",
                template: `
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
                  @if($scheme->schema)
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
                  @endif
              </div>
              </fieldset>
              @endforeach
            </div>   
            {{-- --------------------------------  Koniec schem --------------------------------------------------------- --}}
            <div id='modal'></div>
            {{-- --------------------------------  Priklady  --------------------------------------------------------- --}}
                <div class="row mt-5">
                  <div id="div_radio" class="col-xs-12 col-sm-9 col-lg-9 d-flex">
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
                  
                          @if(!$experiment->layout->checkboxes->isEmpty())
                          <div class="row mt-5">
                          @foreach ($experiment->layout->checkboxes as $box)
                            <div id="div_check_{{ $box->attribute_name }}" class="col-12 col-md-12 mb-5">
                              <label for="checkbox_{{ $box->attribute_name }}">{{ $box->title }}</label>
                              <input type="checkbox" name="checkbox_{{ $box->attribute_name }}" id="checkbox_{{ $box->attribute_name }}" class="toggle{{ $box->id }}">
                            </div>
                            @foreach ($box->dependentSliders->where('visible', 1) as $slider)
                            <div class="col-12 col-md-{{ $slider->columns }} slider-roller">
                              <div id="div_{{ $slider->title }}" class="vstup mb-5 ">
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
                          @endif
                        </fieldset>
            
                        @if($slidersAdditionalCount > 0 || $checkboxesAdditionalCount > 0)
                        <fieldset class="border p-2 mb-5 div_params_additional"> 
                          <legend>Common fields of schemes</legend>
                            <div class="row">       
                              @foreach ($slidersAdditional as $slider)
                              @if($slider->comparison_experiments_count > 1)
                              <div class="col-12 col-md-{{ $slider->columns }} slider-roller mb-4">
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
                              @endif
                              @endforeach
                            </div> 
                  
                            @if(!$checkboxesAdditional->isEmpty())
                            <div class="row mt-5">
                            @foreach ($checkboxesAdditional as $box)
                            @if($box->comparison_experiments_count > 1)
                              <div id="div_check_{{ $box->attribute_name }}" class="col-12 col-md-12 mb-5">
                                <label for="checkbox_{{ $box->attribute_name }}">{{ $box->title }}</label>
                                <input type="checkbox" name="checkbox_{{ $box->attribute_name }}" id="checkbox_{{ $box->attribute_name }}" class="toggle{{ $box->id }}">
                              </div>
                              @foreach ($box->dependentSliders()->withCount('comparisonExperiments')->where('visible', 1)->get() as $slider)
                              @if($slider->comparison_experiments_count > 1)
                              <div class="col-12 col-md-{{ $slider->columns }} slider-roller">
                                <div id="div_{{ $slider->title }}" class="vstup mb-5">
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
                              @endif
                              @endforeach
                            @endif
                            @endforeach
                            </div>
                            @endif
                        </fieldset>
                        @endif
            
                      @foreach ($experiment->schemes()->has('sliders')->get() as $comparison)
                      @if($comparison->sliders()->withCount('comparisonExperiments')->has('comparisonExperiments', '=', 1)->count() > 0)
                      <fieldset class="border p-2 mb-5 div_params_{{ $comparison->prefix }}"> 
                        <legend>{{ $comparison->title }}</legend>
                          <div class="row">       
                            @foreach ($comparison->sliders()->withCount('comparisonExperiments')->doesntHave('dependentCheckboxes')->where('visible',1)->orderBy('sorting')->get() as $slider)
                            @if($slider->comparison_experiments_count == 1)
                            <div class="col-12 col-md-{{ $slider->columns }} slider-roller mb-4">
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
                            @endif
                            @endforeach 
                          </div> 
            
                        @if(!$comparison->checkboxes->isEmpty())
                        <div class="row mt-5">
                        @foreach ($comparison->checkboxes()->withCount('comparisonExperiments')->get() as $box)
                        @if($box->comparison_experiments_count == 1)
                          <div id="div_check_{{ $box->attribute_name }}" class="col-12 col-md-12 mb-5">
                            <label for="checkbox_{{ $box->attribute_name }}">{{ $box->title }}</label>
                            <input type="checkbox" name="checkbox_{{ $box->attribute_name }}" id="checkbox_{{ $box->attribute_name }}" class="toggle{{ $box->id }}">
                          </div>
                          @foreach ($box->dependentSliders()->withCount('comparisonExperiments')->where('visible', 1)->get() as $slider)
                          @if($slider->comparison_experiments_count == 1)
                          <div class="col-12 col-md-{{ $slider->columns }} slider-roller">
                            <div id="div_{{ $slider->title }}" class="vstup mb-5">
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
                          @endif
                          @endforeach
                        @endif
                        @endforeach
                        </div>
                        @endif
                      </fieldset>
                      @endif
                      @endforeach
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
            </footer>`,
                graphs: [],
                schemes: [],
                custom_js: `
                <script>
                // Defined functions ready to use:
                // round(value, decimals)
                // KpGain(Km,T1m,Tdm)
                // KPGain(alfa,Tc)
                // KDGain(alfa,Tc)
                // beta1Gain(alfa,Tf,Tdm)
                // beta2Gain(alfa,Tf,Tdm)
                // alfaGain(T1m,Tdm)
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
                    console.log(response.data);
                    let keys = collect(Object.keys(response.data));
                    keys = keys.map(item => {
                        // zisti ci "_" sa nachadza v stringu ak nie tak vrat povodny item
                        // a neodrez
                        return item.indexOf("_") > 0
                            ? item.substr(0, item.indexOf("_"))
                            : item;
                    });
                    keys = _.uniq(keys.toArray()); // Odstran duplikaty

                    keys = keys.map(item => {
                        // namapuj pre vue multiselect
                        return {
                            id: item,
                            title: item
                        };
                    });

                    console.log(keys);
                    th.responses = keys;
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
                title: "",
                xaxis: "",
                yaxis: "",
                color: "",
                legendgroup: "",
                show_legend: true
            });
        },
        deleteTraceFromGraph: function(index, traceIndex) {
            this.form.graphs[index].traces.splice(traceIndex, 1);
        },

        addScheme: function(event) {
            this.form.schemes.push({
                id: this.form.schemes.length
            });
        },

        deleteScheme: function(index) {
            this.form.schemes.splice(index, 1);
        },
        addCountScheme: function(index) {}
    }
});
