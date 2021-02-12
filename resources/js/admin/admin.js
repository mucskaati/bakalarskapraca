import "./bootstrap";

import "vue-multiselect/dist/vue-multiselect.min.css";
import flatPickr from "vue-flatpickr-component";
import VueQuillEditor from "vue-quill-editor";
import Notifications from "vue-notification";
import Multiselect from "vue-multiselect";
import VeeValidate from "vee-validate";
import "flatpickr/dist/flatpickr.css";
import VueCookie from "vue-cookie";
import { Admin } from "craftable";
import VModal from "vue-js-modal";
import Vue from "vue";

var _ = require("lodash");

// import highlighting library (you can use any library you want just return html string)
// import { highlight, languages } from "prismjs/components/prism-core";
// import "@prismjs/components/prism-clike";
// import "@prismjs/components/prism-javascript";
// import "@prismjs/themes/prism-tomorrow.css"; // import syntax highlighting styles

import "./app-components/bootstrap";
import "./index";

import "craftable/dist/ui";

Vue.component("multiselect", Multiselect);
Vue.use(VeeValidate, { strict: true });
Vue.component("datetime", flatPickr);
Vue.use(VModal, { dialog: true, dynamic: true, injectModalsContainer: true });
Vue.use(VueQuillEditor);
Vue.use(Notifications);
Vue.use(VueCookie);

new Vue({
    mixins: [Admin]
});
