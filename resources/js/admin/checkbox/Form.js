import AppForm from '../app-components/Form/AppForm';

Vue.component('checkbox-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                attribute_name:  '' ,
                layout_id:  '' ,
                title:  '' ,
                
            }
        }
    }

});