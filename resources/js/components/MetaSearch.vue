<template>
    <form ref="filter">
        <div :class="cls">

            <!--Only code you need is this label-->
            <label class="switch">
                <input name="ext" @change="apply" v-model="ext" type="checkbox">
                <div class="slider round"></div>
            </label>
            فقط کالا‌های موجود
        </div>
        <div :class="cls">
            <h2 id="fon">
                مرتب سازی بر اساس:
            </h2>
            <input type="hidden" name="sort" value="sale" id="sort">
            <span class="badge p-2 mb-1 bg-secondary" id="sale" @click="changeSort('sale',$event)">
                پرفروش‌ترین
            </span>
            <span class="badge p-2 mb-1 bg-secondary" id="new" @click="changeSort('new',$event)">
                جدیدترین
            </span>
            <span class="badge p-2 mb-1 bg-secondary" id="fav" @click="changeSort('fav',$event)">
                محبوب‌ترین
            </span>
            <span class="badge p-2 mb-1 bg-secondary" id="cheap" @click="changeSort('cheap',$event)">
                ارزان‌‌ترین
            </span>
            <span class="badge p-2 mb-1 bg-secondary" id="expensive" @click="changeSort('expensive',$event)">
                گران‌ترین
            </span>
        </div>

        <div :class="cls" v-if="minm < maxm">
            <label>
                {{ t.priceRange }}
            </label>
            <VueSimpleRangeSlider
                style="width: 95%;margin: auto"
                :min="minm"
                dir="rtl"
                @input="price()"
                :max="maxm"
                active-bar-color="#1d68a7"
                v-model="state.range"
            >
                <template #prefix="{ value }">ت</template>
            </VueSimpleRangeSlider>
            <input type="hidden" name="from" v-model="state.range[0]">
            <input type="hidden" name="to" v-model="state.range[1]">
        </div>
        <div v-for="d in elms" :class="cls" v-if="d.searchable">
            <div v-if="d.type === 'text'">
                <label :for="d.name">
                    {{ d.label }}
                </label>
                <input v-model="defaults[d.name]" type="text" :id="d.name" :name="'meta['+d.name+']'"
                       class="form-control">
            </div>
            <div v-else-if="d.type === 'number'">
                <label :for="d.name">
                    {{ d.label }}
                    <!--                    "{{defaults[d.name]}}"-->
                </label>
                <input type="number" v-model="defaults[d.name]" :placeholder="d.label" :id="d.name"
                       :name="'meta['+d.name+']'" class="form-control">
            </div>
            <div v-else-if="d.type === 'color'" :id="d.name" :name="'meta['+d.name+']'">
                <label :for="d.name">
                    {{ d.label }}
                </label>
                <select v-model="defaults[d.name]" :name="'meta['+d.name+']'" :id="d.name" class="form-control">
                    <option value=""> {{ d.label }}</option>
                    <option :style="'background-color:' + o.value " :value="o.value" v-for="o in d.options">
                        {{ o.title }}
                    </option>
                </select>
            </div>
            <div v-else-if="d.type === 'checkbox'">
                <!--Only code you need is this label-->
                <label class="switch">
                    <input :name="'meta['+d.name+']'" v-model="defaults[d.name]" type="checkbox">
                    <div class="slider round"></div>
                </label>
                {{ d.label }}


            </div>
            <div v-else-if="d.type === 'select'">
                <label :for="d.name">
                    {{ d.label }}
                </label>
                <select v-model="defaults[d.name]" :name="'meta['+d.name+']'" :id="d.name" class="form-control">
                    <option value=""> {{ t.all }}</option>
                    <option :value="o.value" v-for="o in d.options"> {{ o.title }}</option>
                </select>
            </div>
            <div v-else-if="d.type === 'multi'">
                <label :for="d.name">
                    {{ d.label }}
                </label>

                <multiselect :multiple="true" :taggable="true" label="title" v-model="defaults[d.name]"
                             :placeholder="d.label" :options="d.options"></multiselect>
                <input :id="d.label" type="hidden" :name="'meta['+d.name+']'" :value="makeVal(defaults[d.name])">
            </div>
            <div v-else-if="d.type === 'singlemulti'">
                <label :for="d.name">
                    {{ d.label }}
                </label>
                <multiselect @remove="rem(d.name,$event)" @select="upd(d.name,defaults[d.name])"
                             v-model="defaults[d.name]" :multiple="true" :taggable="true" label="title"
                             :placeholder="d.label" :options="d.options"></multiselect>
                <input type="hidden" :name="'meta['+d.name+']'" :value="makeVal(defaults[d.name])">
            </div>
        </div>

        <button class="btn btn-primary w-100">
            <i class="fa fa-check float-start mt-1"></i>
            اعمال
        </button>
    </form>
</template>

<script>
import multiselect from 'vue-multiselect';
import VueSimpleRangeSlider from "vue-simple-range-slider/vue2";
import "vue-simple-range-slider/vue2/css";

function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

function getURLParam(key, target = window.location.href) {
    var values = [];
    if (!target) target = location.href;

    key = key.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");

    var pattern = key + '=([^&#]+)';
    var o_reg = new RegExp(pattern, 'ig');
    while (true) {
        console.log('x1');
        var matches = o_reg.exec(target);
        if (matches && matches[1]) {
            values.push(matches[1]);
        } else {
            break;
        }
    }

    if (!values.length) {
        return null;
    } else {
        return values.length == 1 ? values[0] : values;
    }
}

export default {
    name: "MetaElement",
    components: {multiselect, VueSimpleRangeSlider},
    data: function () {
        return {
            b: true,
            content: this.value,
            value: '',
            t: window.translate,
            classes: 'form-control',
            elms: [],
            defaults: {},
            ext: false,
            state: {range: [parseInt(this.minm), parseInt(this.maxm)], number: 1000}
        }
    },
    props: ['jdata', 'searchable', 'defz', 'cls', 'minm', 'maxm'],
    mounted() {
        this.updateJdata(this.jdata, this.defz);
        if (getParameterByName('to') !== null) {
            this.state.range[1] = getParameterByName('to');
        }
        if (getParameterByName('from') !== null) {
            this.state.range[0] = getParameterByName('from');
        }
        if (getParameterByName('ext') !== null) {
            this.ext = true;
        }
        if (getParameterByName('sort') !== null) {
            document.querySelector('#' + getParameterByName('sort')).click();
        }


    },
    methods: {
        apply: function () {
            this.$refs.filter.submit();
        },
        changeSort: function (val, e) {
            let x = document.querySelector('.badge.bg-primary');
            x.classList.remove('bg-primary');
            x.classList.add('bg-secondary');
            document.querySelector('#sort').value = val;
            e.target.classList.remove('bg-secondary');
            e.target.classList.add('bg-primary');


        },
        price: function () {
            console.log(this.state);
        },
        upd: function (name, data) {
            this.defaults[name] = data;
            this.$forceUpdate();
        },
        rem: function (name, value) {
            for (const x in this.defaults[name]) {
                let val = this.defaults[name][x];
                if (val.value === value.value) {
                    this.defaults[name].splice(x, 1);
                    this.$forceUpdate();
                    return;
                }
            }
        },
        makeVal: function (ob) {
            return JSON.stringify(ob);
        },
        updateJdata: function (e, def = []) {
            try {

                const params = new URL(window.location.href).searchParams;
                // make defaults
                for (const d of this.elms) {
                    switch (d.type) {
                        case 'checkbox':
                            if (params.get('meta[' + d.name + ']') !== null) {
                                this.defaults[d.name] = true;
                            } else {
                                this.defaults[d.name] = false;
                            }
                            break;
                        case 'select':
                            if (params.get('meta[' + d.name + ']') !== null) {
                                this.defaults[d.name] = params.get('meta[' + d.name + ']');
                            } else {
                                this.defaults[d.name] = '';
                            }

                            break;
                        case 'multi':
                        case 'singlemulti':
                            if (params.get('meta[' + d.name + ']') !== null) {
                                try {
                                    this.defaults[d.name] = JSON.parse(params.get('meta[' + d.name + ']'));
                                } catch {
                                }
                            } else {
                                this.defaults[d.name] = [];
                            }
                            break;
                        default:
                            if (params.get('meta[' + d.name + ']') !== null) {
                                this.defaults[d.name] = params.get('meta[' + d.name + ']');
                            } else {
                                this.defaults[d.name] = '';
                            }
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
                        // fix for multi select object
                        if (e.type === 'multi' || (e.type === '' && this.searchable)) {
                            this.defaults[e.name] = JSON.parse(this.defaults[e.name]);
                        }
                        // console.log(JSON.parse(e.options));
                    } catch {
                    }
                }


            } catch (e) {
                this.elms = [];
                console.log('no meta ele', e.message);
            }

        },
        handleInput(e) {
            this.$emit('input', this.content);
        },
    }
}
</script>

<style scoped>
.switch {
    margin-top: 0px;
    position: relative;
    display: inline-block;
    width: 35px;
    height: 20px;
    float: left;
}

.switch input {
    display: none;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}

input:checked + .slider {
    background-color: #1d68a7;
}

input:focus + .slider {
    box-shadow: 0 0 1px #1d68a7;
}

input:checked + .slider:before {
    -webkit-transform: translateX(16px);
    -ms-transform: translateX(16px);
    transform: translateX(16px);
}

.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}

.scroll {
    height: 150px;
    overflow-y: scroll;
}

label {
    margin-bottom: 4px;
}

select {
    padding: 3px;
    text-align: center;
}
</style>
