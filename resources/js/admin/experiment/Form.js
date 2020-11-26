import Axios from "axios";
import AppForm from "../app-components/Form/AppForm";
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";

Vue.component("experiment-form", {
    mixins: [AppForm],
    props: ["update"],
    components: { Loading },
    data: function() {
        return {
            form: {
                ajax_url: "http://apps.iolab.sk:9000/symetry1b",
                description: "",
                export: false,
                layout: "",
                slug: "",
                title: "",
                custom_js: "",
                graphs: []
            },
            responses: [],
            show_third_step: false,
            isLoading: false
        };
    },
    mounted() {
        if (this.update) {
            this.getResponsesFromServer();
        }
    },
    methods: {
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
        }
    }
});
