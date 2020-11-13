import Axios from "axios";
import AppForm from "../app-components/Form/AppForm";

Vue.component("experiment-form", {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                ajax_url: "",
                description: "",
                export: false,
                layout_id: "",
                title: ""
            },
            responses: []
        };
    },
    methods: {
        getResponsesFromServer() {
            axios
                .get(this.ajax_url, {
                    crossDomain: true
                })
                .then(function(response) {
                    // handle success
                    console.log(response);
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                })
                .then(function() {
                    // always executed
                });
        }
    }
});
