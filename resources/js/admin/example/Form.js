import AppForm from "../app-components/Form/AppForm";

Vue.component("example-form", {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                experiment_id: "",
                title: "Example 1",
                sliders: [],
                checkboxes: [],
                schemes: []
            }
        };
    },
    methods: {
        addSlider: function(event) {
            this.form.sliders.push({
                id: this.form.sliders.length,
                pivot: {
                    value: ""
                }
            });
        },

        deleteSlider: function(index) {
            this.form.sliders.splice(index, 1);
        },

        addCountSlider: function(index) {
            this.form.sliders[index].pivot = {
                value: ""
            };
        },

        addCheckbox: function(event) {
            this.form.checkboxes.push({
                id: this.form.sliders.length,
                pivot: {
                    checked: false
                }
            });
        },

        deleteCheckbox: function(index) {
            this.form.checkboxes.splice(index, 1);
        },

        addCountCheckbox: function(index) {
            this.form.checkboxes[index].pivot = {
                checked: false
            };
        },

        addScheme: function(event) {
            this.form.schemes.push({
                id: this.form.schemes.length,
                pivot: {
                    checked: false
                }
            });
        },

        deleteScheme: function(index) {
            this.form.schemes.splice(index, 1);
        },

        addCountScheme: function(index) {
            this.form.schemes[index].pivot = {
                checked: false
            };
        }
    }
});
