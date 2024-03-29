import AppForm from "../app-components/Form/AppForm";
import SliderFilterMixin from "../mixins/FilterSliderMixin";

Vue.component("checkbox-form", {
    mixins: [AppForm, SliderFilterMixin],
    data: function() {
        return {
            form: {
                attribute_name: "",
                layout: "",
                title: "",
                slider_dependency_change: false,
                dependent_sliders: [],
                comparison_experiments: [],
                type: null
            }
        };
    },
    mounted() {
        this.filterSliders();
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
