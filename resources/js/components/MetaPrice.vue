<template>
    <div>
        <h3>
            {{ t.specialQuantity }}
        </h3>
        <div class="btn btn-success mb-3" @click="adding()">
            <i class="fa fa-plus"></i>
        </div>
        <div class="border p-2" v-for="(q,k) in quantities">
            <div class="row">
                <div v-for="(meta,i) in elms" v-if="meta.priceable" class="col-md">
                    <label :for="meta.name+k">
                        {{ meta.label }}
                    </label>
                    <div v-if="meta.type == 'select' || meta.type == 'multi' || meta.type == 'singlemulti'">
                        <select @change="updateForce" v-model="quantities[k][meta.name]" :id="meta.name+k"
                                :class="'form-control '+(q[meta.name] === ''?'is-invalid':'')">
                            <option value="">{{ t.choose }}</option>
                            <option :value="op.value" v-for="(op,j) in meta.options"> {{ op.title }}</option>
                        </select>
                    </div>
                    <div v-else-if="meta.type == 'color'">
                        <select @change="updateForce" v-model="q[meta.name]" :id="meta.name+k"
                                :class="'form-control '+(quantities[k][meta.name] === ''?'is-invalid':'')">
                            <option value="">{{ t.choose }}</option>
                            <option :style="'background-color:' + o.value " :value="o.value" v-for="o in meta.options">
                                {{ o.title }}
                            </option>
                        </select>
                    </div>
                    <div v-else-if="meta.type == 'number' || meta.type == 'text'">
                        <input @blur="updateForce" type="text" v-model="quantities[k][meta.name]" :id="meta.name+k"
                               :class="'form-control '+(q[meta.name] === ''?'is-invalid':'')">
                    </div>
                    <div v-else>
                        <select @change="updateForce" v-model="quantities[k][meta.name]" :id="meta.name+k"
                                :class="'form-control '+(q[meta.name] === ''?'is-invalid':'')">
                            <option value="">{{ t.choose }}</option>
                            <option value="0"> {{ t.false }}</option>
                            <option value="1"> {{ t.true }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md">
                    <label :for="'price'+k">
                        {{ t.price }}
                    </label>
                    <currency @keyup="updateForce" v-model="quantities[k].price" :placeholder="t.price" :id="'price'+k"
                              classes="form-control"/>
                    <!--                    <input type="text" v-model="q.price" :placeholder="t.price" :id="'price'+k" class="currencyx form-control">-->
                </div>

                <div class="col-md">
                    <label :for="'q'+k">
                        {{ t.count }}
                    </label>
                    <input @keyup="updateForce" :data-id="k" data-key="count" type="text" :placeholder="t.remove"
                           v-model="quantities[k].count" :id="'q'+k" class="form-control">
                </div>
                <div class="col-md">
                    <br>
                    <div class="btn btn-dark mt-2" @click="showModal(k)">
                        <i class="fa fa-image"></i>
                    </div>
                </div>
                <div class="col-md">
                    <br>
                    <div class="btn btn-danger mt-2" @click="rem(k)">
                        {{ t.remove }}
                        <i class="fa fa-trash"></i>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="quantity" :value="JSON.stringify(quantities)">

        <div id="overlay" v-if="modal">
            <div class="container">
                <img src="" alt="" class="selected" style="display: none" />
                <div class="row">
                    <div class="col-md-2 col-sm-6 mt-3" v-for="(img,key,i) in images" :key="key" @click="changeImg(i)">
                        <img :src="img.original_url" :class="quantities[onSelectImage].image === i?'selected':'' " alt="">
                    </div>
                </div>
                <hr>
                <div class="btn btn-danger" @click="hideModal">
                    <div class="fa fa-times"></div>
                </div>
                <div class="btn btn-primary" @click="hideModal">
                    <div class="fa fa-check"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


export default {
    name: "MetaPrice",
    data: function () {
        return {
            quantities: [],
            elms: [],
            t: window.translate,
            q: {},
            last: [],
            onSelectImage: 0,
            modal: false,
        }
    },
    props: ['jdata', 'defz', 'images'],
    mounted() {
        this.updateJdata(this.jdata, this.defz);
    },
    watch: {
        quantities: {
            handler: function (val, oldVal) {
                // Return the object that changed
                // console.log('changed qn');
            },
            deep: true
        }
    },
    methods: {
        changeImg:function ($k) {
            // console.log($k);
            // console.log(this.onSelectImage);
            // console.log(this.quantities);
            this.quantities[this.onSelectImage].image = $k;
            // console.log(this.quantities);
            this.$forceUpdate();
        },
        showModal: function (i) {
            // this.showModal(i);
            this.onSelectImage = i;
            this.modal = true;
        },
        hideModal:function (){

            this.modal = false;
        },
        updateJdata: function (e, def = []) {
            try {

                // make defaults
                if (this.quantities.length == 0) {
                    for (const d in def) {
                        this.quantities[d] = JSON.parse(def[d]);
                    }
                }

                if (typeof e == 'string') {
                    this.elms = JSON.parse(e);
                } else {
                    this.elms = e;
                }


                for (const e of this.elms) {
                    try {
                        e.options = JSON.parse(e.options);
                    } catch {
                    }
                }


            } catch (e) {
                this.elms = [];
                console.log('no meta ele', e.message);
            }

            this.$forceUpdate();

        },
        updateForce: function (e) {
            // this.quantities[e.target.getAttribute('data-id')][e.target.getAttribute('data-key')] = e.target.value;
            this.quantities.push({});
            this.quantities.pop();
        },
        adding: function () {
            let temp = {
                count: 0,
                price: 0,
                image:0,
            };
            for (const meta of this.elms) {
                temp[meta.name] = '';
            }
            this.quantities.push(temp);
        },
        parsing: function (e) {
            try {
                return JSON.parse(e);
            } catch (e) {
                console.log(e.message);
                return [];
            }
        },
        rem(i) {
            // console.log(this.quantities[i]);
            this.quantities.splice(i, 1);
        },

    }
}
</script>

<style scoped>
#overlay {
    position: fixed;
    left: 0;
    right: 0;
    bottom: 0;
    top: 0;
    background: #FFFFFF99;
    z-index: 999;
    overflow-y: scroll;
    backdrop-filter: blur(3px);
}


#overlay img {
    max-width: 100%;
    width: 100%;
    opacity: .75;
    height: 150px;
    object-fit: cover;
}

#overlay img.selected {
    opacity: 1;
    border: 3px double black;
}
</style>
