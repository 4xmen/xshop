<template>
    <div class="row">
        <div v-for="d in elms" :class="d.width+' mb-3'">
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
                <label :for="d.name">
                    {{ d.label }}
                </label>
                <br>
                <div class="panel panel-default ">
                    <div class="panel-body">
                        <!--Only code you need is this label-->
                        <label class="switch">
                            <input :name="'meta['+d.name+']'"  v-model="defaults[d.name]" type="checkbox" >
                            <div class="slider round"></div>
                        </label>
                        <p>

                        </p>
                    </div>
                </div>

            </div>
            <div v-else-if="d.type === 'select'">
                <label :for="d.name">
                    {{ d.label }}
                </label>
                <select v-model="defaults[d.name]" :name="'meta['+d.name+']'" :id="d.name" class="form-control">
                    <option value=""> {{ d.label }}</option>
                    <option :value="o.value" v-for="o in d.options"> {{ o.title }}</option>
                </select>
            </div>
            <div v-else-if="d.type === 'multi'">
                <label :for="d.name">
                    {{ d.label }}
                </label>
                <multiselect @select="upd()" :multiple="true" :taggable="true" label="title" v-model="defaults[d.name]"
                             :placeholder="d.label" :options="d.options"></multiselect>
                <input :id="d.label" type="hidden" :name="'meta['+d.name+']'" :value="makeVal(defaults[d.name])">
            </div>
            <div v-else-if="d.type === 'singlemulti'">
                <label :for="d.name">
                    {{ d.label }}
                </label>
                <div v-if="searchable">
                    <multiselect @select="upd()" v-model="defaults[d.name]" :multiple="true" :taggable="true" label="title"
                                 :placeholder="d.label" :options="d.options"></multiselect>
                    <input type="hidden" :name="'meta['+d.name+']'" :value="defaults[d.name]">
                </div>
                <select v-else v-model="defaults[d.name]" :name="'meta['+d.name+']'" :id="d.name" class="form-control">
                    <option value=""> {{ d.label }}</option>
                    <option :value="o.value" v-for="o in d.options"> {{ o.title }}</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
import multiselect from 'vue-multiselect';

export default {
    name: "MetaElement",
    components: {multiselect},
    data: function () {
        return {
            b: true,
            content: this.value,
            value: '',
            t: window.translate,
            classes: 'form-control',
            elms: [],
            defaults: {},
        }
    },
    props: ['jdata', 'searchable', 'defz'],
    mounted() {
        this.updateJdata(this.jdata, this.defz);
    },
    methods: {
        upd:function () {
            this.$forceUpdate();
        },
        makeVal:function (ob) {
            return JSON.stringify(ob);
        },
        updateJdata: function (e, def = []) {
            try {

                // make defaults
                for (const d of def) {
                    this.defaults[d.key] = d.value;
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
                        if (e.type === 'multi' || (e.type ==='' && this.searchable)){
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
    margin-top: 10px;
    position: relative;
    display: inline-block;
    width: 35px;
    height: 20px;
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
</style>
