import AppForm from "../app-components/Form/AppForm";

Vue.component("checkbox-form", {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                attribute_name: "",
                layout: "",
                title: "",
                dependent_sliders: []
            }
        };
    },
    methods: {
        addDependency: function(event) {
            this.form.dependent_sliders.push({
                id: this.form.dependent_sliders.length,
                pivot: {
                    value_function: ""
                }
            });
        },

        deleteDependency: function(index) {
            this.form.dependent_sliders.splice(index, 1);
        },

        addCountDependency: function(index) {
            this.form.dependent_sliders[index].pivot = {
                value_function: ""
            };
        }
    }
});
