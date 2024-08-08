<template>
    <div id="qIndex">
        <button type="button" v-for="(q,i) in qz" :class="getClass(i)" @click="changeIndex(i)">
            <q-preview :q="q"></q-preview>
            {{priceing(q.price)}}
        </button>
        <input type="hidden" :name="xname" v-if="xname != null" :value="id">
    </div>
</template>

<script>
import QPreview from "./Qpreview.vue";

function commafy(num) {
    if (typeof num !== 'string') {
        return '';
    }
    let str = uncommafy(num.toString()).split('.');
    if (str[0].length >= 4) {
        str[0] = str[0].replace(/(\d)(?=(\d{3})+$)/g, '$1,');
    }
    if (str[1] && str[1].length >= 4) {
        str[1] = str[1].replace(/(\d{3})/g, '$1 ');
    }
    return str.join('.');
}

function uncommafy(txt) {
    return txt.split(',').join('');
}

export default {
    name: "qIndex",
    components: {QPreview},
    data: () => {
        return {
            index:0,
            id: null,
        }
    },
    props: {
        qz:{
            required:[],
        },
        basePrice:{
            default:0,
        },
        symbol:{
            required: true,
        },
        onChange:{
            type: Function,
            default: function (i,q){},
        },
        i:{
            default: 0,
            type: Number,
        },
        xname:{
            default: null,
        }
    },
    mounted() {
        for( const i in this.qz) {
            const q = this.qz[i];
           if (q.price == this.basePrice){
               this.index = i;
               this.id = q.id;
           }
        }

    },
    computed: {},
    methods: {
        changeIndex(i){
            this.index = i;
            this.onChange(this.i, this.qz[i]);
            this.id =  this.qz[i].id;
        },
        priceing(p) {
            if (p == null || p == undefined) {
                return '';
            }
            return commafy(p.toString()) + ' ' + this.symbol;
        },
        getClass(i){
            let cls = 'q';
            if (i == this.index){
                cls += ' selected';
            }

            return cls;
        }
    }
}
</script>

<style scoped>
#qIndex {
}
.q{
    border: 1px solid var(--xshop-secondary);
    border-radius: var(--xshop-border-radius);
    margin-bottom: 4px;
    background: transparent;
    display: block;
    color: var(--xshop-text);
    width: 100%;
    div{
        display: inline-block;
    }


    &.selected{
        background: var(--xshop-primary);
        color: var(--xshop-diff);
    }
}


</style>
