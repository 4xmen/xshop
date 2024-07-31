import 'bootstrap';
import { createApp } from 'vue';
import ToastPlugin from 'vue-toast-notification';
import {useToast} from 'vue-toast-notification';
import store from "../client-vuex/client-store.js";
import chartjs from 'chart.js/auto';


const app = createApp({});
const $toast = useToast({
    duration: 10000,
});


import MetaFilter from './../client-vue/meta-filter.vue';
app.component('meta-filter', MetaFilter);

app.use(ToastPlugin);
app.use(store);
app.mount('#app');

window.app = app;
window.$toast = $toast;
window.store = store;
