import Vue from "vue";
import MainApp from './components/MainApp.vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';
import router from "./router";

const app = new Vue({
   el: '#app',
    router,
   render: h => h(MainApp),
});
