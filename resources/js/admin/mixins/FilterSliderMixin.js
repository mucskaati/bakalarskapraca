var mixin = {
    props: ["sliders"],
    data: function() {
        return {
            filteredSliders: []
        };
    },
    mounted() {
        this.filteredSliders = this.sliders;
    },
    methods: {
        filterSliders() {
            let th = this;
            this.filteredSliders = this.sliders.filter(item => {
                if (this.form.type == "fo") {
                    return item.layout_id == th.form.layout.id;
                } else {
                    return (
                        item.comparison_experiment_id ==
                        th.form.comparison_experiment.id
                    );
                }
            });
        }
    }
};

export default mixin;
