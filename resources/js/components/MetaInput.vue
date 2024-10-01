<template>
    <div id="meta-input">
        <div id="img-modal" @click.self="modal = false" v-if="modal" class="d-flex align-items-center justify-content-center">
           <div class="container">
               <div class="row">
                   <div :class="`col-md-4 `+(j == quantities[qOnEdit].image?'selected-img':'')" v-for="(img,j) in imgz" >
                       <img :src="img.original_url" @click="changeImgIndex(j)" alt="{{img.id}}" class="img-index">
                   </div>
               </div>
           </div>
        </div>
        <div class="row">
            <div v-for="prop in properties" :class="prop.width">
                <label for="prop.name" v-if="prop.type != 'checkbox'">
                    {{ prop.label }}
                    <!--                    [{{prop.type}}]-->
                </label>
                <div v-else class="mt-2">
                    <br>
                </div>
                <div v-if="meta[prop.name] != undefined" class="position-relative">
                    <template v-if="prop.type == 'text'">
                        <input type="text" :id="prop.name" v-model="meta[prop.name]" class="form-control">
                    </template>
                    <template v-if="prop.type == 'number'">
                        <input type="number" :id="prop.name" v-model="meta[prop.name]" class="form-control">
                    </template>
                    <template v-if="prop.type == 'checkbox'">
                        <div class="form-check form-switch">
                            <input class="form-check-input" v-model="meta[prop.name]" type="checkbox" role="switch"
                                   :id="prop.name">
                            <label class="form-check-label" :for="prop.name">{{ prop.label }}</label>
                        </div>
                    </template>
                    <template v-if="prop.type == 'color'">
                        <select :id="prop.name" class="form-control color" v-model="meta[prop.name]">
                            <option v-for="op in prop.optionList" :style="`background: ${op.value} ;`"
                                    :value="op.value"> {{ op.title }}
                            </option>
                        </select>
                        <div class="sq" :style="`background: ${meta[prop.name]} ;`"></div>
                    </template>
                    <template v-if="prop.type == 'select' || prop.type == 'singemulti'">
                        <select :id="prop.name" class="form-control color" v-model="meta[prop.name]">
                            <option v-for="op in prop.optionList" :value="op.value"> {{ op.title }}</option>
                        </select>
                    </template>
                    <template v-if="prop.type == 'multi'">
                        <searchable-multi-select :items="prop.optionList" value-field="value"
                                                 v-model="meta[prop.name]"></searchable-multi-select>   
                    </template>
                    <template v-if="prop.type == 'date'">
                        <vue-date-time-picker v-model="meta[prop.name]"></vue-date-time-picker>
                    </template>
                    <template v-if="prop.type == 'time'">
                        <vue-time-picker v-model="meta[prop.name]" :am-pm="false"></vue-time-picker>
                    </template>
                </div>
            </div>
        </div>
        <div v-if="hasPriceable && productId != null" class="mt-4">

            <h4>
                Quantities:
                <!--   WIP: transalte-->
            </h4>
            <button type="button" class="btn btn-light w-100 mb-2" @click="addQ">
                <i class="ri-add-line"></i>
            </button>

            <!--            qz: {{ quantitiez }}, qs: {{ quantities }}-->
            <div class="row mt-1" v-for="(q,n) in quantities">
                <template v-for="prop in properties">
                    <div v-if="prop.priceable" class="col-md">
                        <label for="prop.name" v-if="prop.type != 'checkbox'">
                            {{ prop.label }}
                            <!--                    [{{prop.type}}]-->
                        </label>
                        <div v-if="meta[prop.name] != undefined" class="position-relative">
                            <template v-if="prop.type == 'text'">
                                <input type="text" :id="prop.name" v-model="q.data[prop.name]" class="form-control">
                            </template>
                            <template v-if="prop.type == 'number'">
                                <input type="number" :id="prop.name" v-model="q.data[prop.name]" class="form-control">
                            </template>
                            <template v-if="prop.type == 'checkbox'">
                                <br>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" v-model="q.data[prop.name]" type="checkbox"
                                           role="switch"
                                           :id="prop.name">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">{{
                                            prop.label
                                        }}</label>
                                </div>
                            </template>
                            <template v-if="prop.type == 'color'">
                                <select :id="prop.name" class="form-control color" v-model="q.data[prop.name]">
                                    <option v-for="op in prop.optionList" :style="`background: ${op.value} ;`"
                                            :value="op.value"> {{ op.title }}
                                    </option>
                                </select>
                                <div class="sq" :style="`background: ${q.data[prop.name]} ;`"></div>
                            </template>
                            <template v-if="prop.type == 'select' || prop.type == 'singemulti'">
                                <select :id="prop.name" class="form-control color" v-model="q.data[prop.name]">
                                    <option v-for="op in prop.optionList" :value="op.value"> {{ op.title }}</option>
                                </select>
                            </template>
                            <template v-if="prop.type == 'multi'">
                                <searchable-multi-select xname="" :items="prop.optionList" value-field="value"
                                                         v-model="q.data[prop.name]"></searchable-multi-select>
                            </template>
                            <template v-if="prop.type == 'date'">
                                <vue-date-time-picker v-model="q.data[prop.name]"></vue-date-time-picker>
                            </template>
                            <template v-if="prop.type == 'time'">
                                <vue-time-picker v-model="q.data[prop.name]" :am-pm="false"></vue-time-picker>
                            </template>
                        </div>
                    </div>
                </template>
                <div class="col-md">
                    <label :for="`qid-${n}`">
                        Count:   <!-- WIP: transalte-->
                    </label>
                    <input type="number" placeholder="Count" :id="`qid-${n}`" min="0" v-model="q.count" class="form-control">
                </div>
                <div class="col-md">
                    <label :for="`prc-${n}`">
                        Price:   <!-- WIP: transalte-->
                    </label>
                    <currency-input :xid="`qid-${n}`" xtitle="Price" v-model="q.price"></currency-input>
                </div>
                <div class="col-md" v-if="imgz.length > 0">
                    <label :for="`img-${n}`">
                        image:   <!-- WIP: transalte-->
                    </label>

                    <button type="button" class="btn btn-outline-info d-block w-100" @click="showModal(n)">
                        <i class="ri-image-2-line"></i>
                    </button>
                </div>
                <div class="col-md-1">
                    <br>
                    <button type="button" class="btn btn-outline-danger d-block w-100" @click="remQ(n)">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
            </div>
        </div>
<!--        {{quantities}}-->
        <input type="hidden" name="meta" :value="JSON.stringify(meta)">
        <input type="hidden" name="q" :value="JSON.stringify(quantities)">
    </div>
</template>

<script>

import {mapState} from "vuex";
import searchableMultiSelect from "./SearchableMultiSelect.vue";
import CurrencyInput from "./CurrencyInput.vue";
import VueDateTimePicker from "./vueDateTimePicker.vue";
import vueTimePicker from "./vueTimePicker.vue";

function arraysEqual(arr1, arr2) {
    if (arr1.length !== arr2.length) {
        return false;
    }

    const sortedArr1 = arr1.slice().sort();
    const sortedArr2 = arr2.slice().sort();

    return sortedArr1.every((value, index) => value === sortedArr2[index]);
}
export default {
    name: "meta-input",
    components: {
        searchableMultiSelect,
        CurrencyInput,
        VueDateTimePicker,
        vueTimePicker,
    },
    data: () => {
        return {
            properties: [],
            meta: {},
            hasPriceable: false,
            quantities: [],
            qOnEdit: 0,
            modal: false,
            lastCat: null,
        }
    },
    props: {
        imgz:{
            default: []
        },
        propsApiLink: {
            required: true,
        },
        metaz: {
            default: [],
        },
        quantitiez: {
            default: [],
        },
        productId: {
            default: null,
        }
    },
    mounted() {
        // this.quantities = this.quantitiez;
        for( const q of this.quantitiez) {
            q.data = JSON.parse(q.data);
            this.quantities.push(q);
        }


    },
    computed: {
        category_id: {
            get() {
                return this.$store.state.category;
            },
            set(value) {
                this.$store.commit('UPDATE_CATEGORY', value)
            }
        },
        qsid: {
            get() {
                return this.$store.state.quantities;
            },
            set(value) {
                // this.$store.commit('UPDATE_CATEGORY', value)
            }
        },
        qid(){
            let r = [];
            for( const q of this.quantities) {
              r.push(q.id);
            }

            return r;
        }
    },
    methods: {

        showModal(i){
            // console.log('ii',i);
            this.qOnEdit = i;
            this.modal = true;
        },
        changeImgIndex(i){
            // console.log('jjj',i);
          this.quantities[this.qOnEdit].image = i;
        },
        remQ(i){
          this.quantities.splice(i,1);
        },
        addQ() {
            let data = {
                id: null,
                product_id: this.productId,
                image: null,
                price: 0,
                count: 0,
                data: {},
            };
            for (const prop of this.properties) {
                // check priceable
                if (prop.priceable) {
                    data.data[prop.name] = '';
                }
            }
            this.quantities.push(data);
        },
        async updateProps() {
            try {
                const url = this.propsApiLink + this.category_id;
                let resp = await axios.get(url);
                this.properties = resp.data.data;
                // added don't have
                for (const prop of this.properties) {
                    // check priceable
                    if (prop.priceable) {
                        this.hasPriceable = true;
                    }
                    if (this.meta[prop.name] == undefined) {
                        if (prop.type == 'multi') {
                            this.meta[prop.name] = [];
                        } else {
                            this.meta[prop.name] = '';
                        }
                    }
                }

                // update by old meta data
                for (const meta in this.metaz) {
                    this.meta[meta] = this.metaz[meta];
                }


            } catch (e) {
                window.$toast.error(e.message);
            }

        },
    },
    watch: {
        category_id: function (old,n) {
            // console.log(old,n,'x');
            // if (this.lastCat != this.category_id){
            //     this.lastCat = this.category_id;
                this.updateProps();
            // }
        },
        qsid: function () {
            if (!arraysEqual(this.qid,this.qsid)){
                window.location.href = window.redirect;
            }
        }
    }
}
</script>

<style scoped>
#meta-input {

}

.color option {

}

.sq {
    width: 37px;
    height: 37px;
    background: transparent;
    border: 1px solid black;
    position: absolute;
    inset-inline-end: 0;
    top: 0;
    border-radius: 4px;
}

#img-modal{
    position: fixed;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    background: #00000033;
    backdrop-filter: blur(5px);
    z-index: 10;
    //display: none;
}

.img-index{
    width: 100%;
    height: 25vh;
    min-height: 200px;
    object-fit: cover;
}
.selected-img{
    background: darkred;
}
</style>
