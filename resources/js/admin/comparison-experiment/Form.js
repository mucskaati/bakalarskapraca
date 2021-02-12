import AppForm from "../app-components/Form/AppForm";

Vue.component("comparison-experiment-form", {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                title: "",
                description: "",
                prefix: "",
                trace_color: "",
                legendgroup: ""
            },
            mediaCollections: ["schema"]
        };
    }
});
