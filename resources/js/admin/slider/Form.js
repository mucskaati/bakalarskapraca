import AppForm from "../app-components/Form/AppForm";

Vue.component("slider-form", {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                default: "",
                default_function: "",
                layout: "",
                comparison_experiments: [],
                max: "",
                min: "",
                step: "",
                title: "",
                columns: "",
                sorting: "",
                visible: true,
                dependencies: [],
                type: null
            },
            filters: {
                experiments: []
            }
        };
    },

    methods: {
        addDependency: function(event) {
            this.form.dependencies.push({
                id: this.form.dependencies.length,
                pivot: {
                    value_same_as_added: true,
                    value_function: ""
                }
            });
        },

        deleteDependency: function(index) {
            this.form.dependencies.splice(index, 1);
        },

        addCountDependency: function(index) {
            this.form.dependencies[index].pivot = {
                value_same_as_added: true,
                value_function: ""
            };
        }
    }
});
