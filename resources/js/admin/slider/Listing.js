import AppListing from "../app-components/Listing/AppListing";

Vue.component("slider-listing", {
    mixins: [AppListing],
    data() {
        return {
            layoutMultiselect: [],
            comparisonMultiselect: [],

            filters: {
                layouts: [],
                schemes: []
            }
        };
    },
    mounted() {
        if (localStorage.schemes && localStorage.objectsSchemes) {
            this.comparisonMultiselect = JSON.parse(
                localStorage.objectsSchemes
            );
            this.filters.schemes = localStorage.schemes.split(",");
            this.filter("schemes", this.filters.schemes);
        }

        if (localStorage.layouts && localStorage.objectsLayouts) {
            this.layoutMultiselect = JSON.parse(localStorage.objectsLayouts);
            this.filters.layouts = localStorage.layouts.split(",");
            this.filter("layouts", this.filters.layouts);
        }
    },
    watch: {
        layoutMultiselect: function(newVal, oldVal) {
            this.filters.layouts = newVal.map(function(object) {
                return object["id"];
            });
            localStorage.objectsLayouts = JSON.stringify(
                this.layoutMultiselect
            );
            localStorage.layouts = this.filters.layouts;
            this.filter("layouts", this.filters.layouts);
        },
        comparisonMultiselect: function(newVal, oldVal) {
            this.filters.schemes = newVal.map(function(object) {
                return object["id"];
            });
            localStorage.objectsSchemes = JSON.stringify(
                this.comparisonMultiselect
            );
            localStorage.schemes = this.filters.schemes;
            this.filter("schemes", this.filters.schemes);
        }
    }
});
