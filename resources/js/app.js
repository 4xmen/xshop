/**
 * common function
 */
// const _q = function (selector){
//     return document.querySelector(selector);
// }


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import ToastPlugin from 'vue-toast-notification';
import {useToast} from 'vue-toast-notification';
import store from "./components/libs/store.js";
import './panel/raw.js';
import './panel/navbar.js';
import './panel/list-checkboxs.js';
import './panel/general-events.js';
import './panel/editor-handle.js';
import './panel/step-controller.js';
import './panel/product-upload-controller.js';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});
const $toast = useToast({
    duration: 10000,
});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

import VueJalaliCalendar from './components/vueJalaliCalendar.vue';
app.component('vue-jalali-calendar', VueJalaliCalendar);

import CurrencyInput from './components/CurrencyInput.vue';
app.component('currency-input',CurrencyInput);

import RemixIconPicker from './components/RemixIconPicker.vue';
app.component('remix-icon-picker', RemixIconPicker);

import FontAwesomeIconPicker from "./components/FontAwesomeIconPicker.vue";
app.component('awesome-icon-picker', FontAwesomeIconPicker);

import vueDateTimePicker from "./components/vueDateTimePicker.vue";
app.component('vue-datetime-picker-input', vueDateTimePicker);

import vueDateRangePicker from "./components/vueDateRangePicker.vue";
app.component('vue-date-range-picker-input', vueDateRangePicker);

import SearchableSelect from "./components/SearchableSelect.vue";
app.component('searchable-select', SearchableSelect);

import SearchableMultiSelect from "./components/SearchableMultiSelect.vue";
app.component('searchable-multi-select', SearchableMultiSelect);

import Increment from "./components/Increment.vue";
app.component('increment', Increment);

import TagInput from "./components/TagInput.vue";
app.component('tag-input', TagInput);

import SliderData from "./components/SliderData.vue";
app.component('slider-data', SliderData);

import AddressInput from "./components/AddressInput.vue";
app.component('address-input', AddressInput);

import PropTypeInput from "./components/PropTypeInput.vue";
app.component('props-type-input', PropTypeInput);

import MetaInput from "./components/MetaInput.vue";
app.component('meta-input', MetaInput);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
app.use(ToastPlugin);
app.use(store);
app.mount('#app');

window.app = app;
window.$toast = $toast;
window.store = store;
