import Axios from "axios";
import AppForm from "../app-components/Form/AppForm";
import Loading from "vue-loading-overlay";
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
    mixins: [AppForm],
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
                  <div class="tile" id="check_{{ $scheme->prefix }}">
                      <span>
                            <label for="choice_{{ $scheme->prefix }}" id="choice_label_{{ $scheme->prefix }}" class="checkbox-choice-label">{{ $scheme->title }}</label>
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
                    <div class="col-md-6">
                      <h2>Simulations</h2>
                    </div>
                    <div class="col-md-6 text-right">
                      <button id="switchButton" class="d-inline-block btn btn-primary">Toggle Sliders / Text Inputs</button>
                      @if($experiment->run_button)
                      <button id="runButton" class="d-inline-block btn btn-danger">Run</button>
                      @endif
                    </div>
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
                      </div>`,
                graphs: [],
                schemes: []
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
