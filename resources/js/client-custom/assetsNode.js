import { createApp } from 'vue';
import ToastPlugin from 'vue-toast-notification';
import {useToast} from 'vue-toast-notification';
import store from "../client-vuex/client-store.js";
import chartjs from 'chart.js/auto';


const app = createApp({});
const $toast = useToast({
    duration: 10000,
});

import MetaFilter from '../client-vue/MetaFilter.vue';
app.component('meta-filter', MetaFilter);

import QuantitiesAddToCard from "../client-vue/QuantitiesAddToCard.vue";
app.component('quantities-add-to-card', QuantitiesAddToCard);

import videoPlayer from "../client-vue/videoPlayer.vue";
app.component('mp4player', videoPlayer);

import mp3player from "../client-vue/mp3player.vue";
app.component('mp3player', mp3player);

import addressInput from "../client-vue/AddressInput.vue";
app.component('address-input', addressInput);

import NsCard from "../client-vue/NsCard.vue";
app.component('ns-card', NsCard);

import RateInput from "../client-vue/RateInput.vue";
app.component('rate-input', RateInput);


import vdp from "../client-vue/vueDateTimePickerClient.vue";
app.component('vue-datetime-picker-input', vdp);


app.use(ToastPlugin);
app.use(store);
app.mount('#app');

window.app = app;
window.$toast = $toast;
window.store = store;
