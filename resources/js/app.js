/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('jquery-sortable/source/js/jquery-sortable');
// require('persian-datepicker/dist/js/persian-datepicker.min');

let loadJsAfterDone = [
    '/js/persian-datepicker.min',
    '/js/persian-date.min'
]

window.Vue = require('vue').default;
require('./wizard');
require('./currncy');
require('./multi-image-uploader');
require('./propz');
require('./product');
require('./customer')
require('./other');
require('./general');



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



window.addEventListener("load", async function() {
   for( const js of loadJsAfterDone) {
       await $.getScript(js+".js");
   }
   $('.dtp').each(function () {
     $(this).persianDatepicker({
           observer: true,
           initialValue: false,
           format: 'YYYY/MM/DD',
           altField: $(this).data('reuslt')
       });
   });
    $('.dtp').dblclick(function () {
      $(this).val('-');
      $($(this).data('reuslt')).val('');
    });



});
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('meta-price', require('./components/MetaPrice.vue').default);
Vue.component('currency', require('./components/CurrencyInput.vue').default);
Vue.component('meta-element', require('./components/MetaElement.vue').default);
var app = new Vue({
    el: '#app',
    data: {
        metaz: '123',
        jdata: [],
        def: [],
    },
    mounted() {

    },
    created() {
        if (document.querySelector('#jDataSrc') !== undefined){
            try {
                this.jdata = JSON.parse(document.querySelector('#jDataSrc').value);
                this.def = JSON.parse(document.querySelector('#jDef').value);
            } catch {
                console.log('json error: for meta product page');
            }
        }
    },
    methods: {
    },
    watch:{
        jdata:{
            handler: function(n) {
                this.$refs.metaEl.updateJdata(n);
                this.$refs.metaPr.updateJdata(n);
            },
            deep: true
        },
    }
});
window.app = app;
