import { collect } from "collect.js";

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
                if (th.form.type == "fo") {
                    return item.layout_id == th.form.layout.id;
                } else {
                    return (
                        collect(item.comparison_experiments)
                            .whereIn(
                                "id",
                                collect(th.form.comparison_experiments)
                                    .pluck("id")
                                    .toArray()
                            )
                            .count() > 0
                    );
                }
            });
        }
    }
};

export default mixin;
