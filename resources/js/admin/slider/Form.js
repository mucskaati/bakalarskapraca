import AppForm from "../app-components/Form/AppForm";

Vue.component("slider-form", {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                default: "",
                default_function: "",
                layout_id: "",
                max: "",
                min: "",
                step: "",
                title: "",
                dependencies: []
            }
        };
    },

    methods: {
        addDependency: function(event) {
            this.form.dependencies.push({
                id: this.form.dependencies.length,
                pivot: {
                    dependent_layout: "",
                    same_as_added_slider: true,
                    value_function: ""
                }
            });
        },

        deleteDependency: function(index) {
            this.form.dependencies.splice(index, 1);
        },

        addCountDependency: function(index) {
            this.form.dependencies[index].pivot = {
                dependent_layout: "",
                same_as_added_slider: true,
                value_function: ""
            };
        }
    }
});
