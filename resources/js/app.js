
import Vue from 'vue';

require('./bootstrap');


axios.defaults.headers.common["X-CSRF-TOKEN"] = window.Laravel.csrfToken;
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

const files = require.context("./", true, /\.vue$/i);
files.keys().map(key =>
    Vue.component(
        key
            .split("/")
            .pop()
            .split(".")[0],
        files(key).default
    )
);

import VueGeolocation from 'vue-browser-geolocation';
Vue.use(VueGeolocation);

import VueQrcodeReader from "vue-qrcode-reader";
Vue.use(VueQrcodeReader);

import * as VueGoogleMaps from 'vue2-google-maps'
Vue.use(VueGoogleMaps, {
    load: {
      key: 'AIzaSyDgh7OHtp1OWtnwRB1PRJHFCv141RlxAmM',
      libraries: 'places', // This is required if you use the Autocomplete plugin
      // OR: libraries: 'places,drawing'
      // OR: libraries: 'places,drawing,visualization'
      // (as you require)

      //// If you want to set the version, you can do so:
      // v: '3.26',
    },
    installComponents: true
})

import html2canvas from 'html2canvas';

import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import "element-ui/lib/theme-chalk/display.css";
import locale from "element-ui/lib/locale/lang/en";

import EventDispatcher from "./service/EventDispatcher.js";
import API from "./api/index.js";
import DateFormatter from "./service/DateFormatter";


import router from "./router";

Vue.prototype.$EventDispatcher = new EventDispatcher();
Vue.prototype.$API = API;
Vue.prototype.$df = new DateFormatter();

Vue.use(ElementUI, { locale, size: "small" });

Vue.config.productionTip = false;
const app = new Vue({
    el: '#app',
    router,
});



function saveimg() {
    alert('asdasd')
}
