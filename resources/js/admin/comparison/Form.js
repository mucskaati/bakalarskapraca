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
                template: ``,
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
