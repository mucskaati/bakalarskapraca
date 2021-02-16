import AppForm from "../app-components/Form/AppForm";

Vue.component("example-form", {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                experiment_id: "",
                title: "Example 1",
                sliders: [],
                checkboxes: []
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
                id: this.form.sliders.length
            });
        },

        deleteCheckbox: function(index) {
            this.form.checkboxes.splice(index, 1);
        },

        addCountCheckbox: function(index) {}
    }
});
