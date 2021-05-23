import Vue from "vue";
import MainApp from './components/MainApp.vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';
import router from "./router";
import common from "./common";
import store from "./store/store.js";
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';

Vue.mixin(common);
Vue.use(ViewUI);

const app = new Vue({
   el: '#app',
    router,
    store,
   render: h => h(MainApp),
});
