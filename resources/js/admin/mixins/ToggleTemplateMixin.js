var mixin = {
    data: function() {
        return {
            showTemplate: false
        };
    },
    methods: {
        toggleTemplate() {
            this.showTemplate = !this.showTemplate;
        }
    }
};

export default mixin;
