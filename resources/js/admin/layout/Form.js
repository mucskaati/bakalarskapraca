import AppForm from "../app-components/Form/AppForm";

Vue.component("layout-form", {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                columns: "",
                height: "",
                margin: "{l: 4 , r:5, b:10, t:10, pad:5}",
                name: "",
                rows: "",
                type: "fo",
                width: "",
                xaxis: "{domain: [0, 1]}",
                yaxis: "{range: [0, 1]}"
            }
        };
    }
});
