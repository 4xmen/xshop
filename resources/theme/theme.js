axios = require('axios');
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

alertify = require('alertifyjs');
require('../js/bootstrap');
window._ = require('lodash');
require('bootstrap/dist/js/bootstrap.bundle')
require('chart.js/dist/chart.min')
var $ = window.jQuery = jQuery = require('jquery');
require('lightbox2/dist/js/lightbox.min');
require('owl.carousel/dist/owl.carousel.min');
require('xzoom/dist/xzoom.min');

window.Vue = require('vue').default;

// require('./js/gsap.min.js');
// require('./js/Physics2DPlugin3.min');
require('./js/mega-menu.js');
require('./js/product.js');
require('./js/theme.js');
require('./js/chart.js');
require('../js/customer.js');

// require('../js/')
Vue.component('example-component', require('../js/components/ExampleComponent.vue').default);
Vue.component('meta-price', require('../js/components/MetaPrice.vue').default);
Vue.component('currency', require('../js/components/CurrencyInput.vue').default);
Vue.component('meta-element', require('../js/components/MetaElement.vue').default);
Vue.component('meta-search', require('../js/components/MetaSearch').default);

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
                // this.$refs.metaPr.updateJdata(n);
            },
            deep: true
        },
    }
});
window.app = app;


