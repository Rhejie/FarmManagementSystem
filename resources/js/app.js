
import Vue from 'vue';

require('./bootstrap');



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


