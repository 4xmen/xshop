<template>
    <div id="meta-input">
        <div class="row">
            <div v-for="prop in properties" :class="prop.width">
                <label for="prop.name" v-if="prop.type != 'checkbox'">
                    {{prop.label}}
<!--                    [{{prop.type}}]-->
                </label>
                <div v-else class="mt-2">
                    <br>
                </div>
                <template v-if="meta[prop.name] != undefined">
                    <template v-if="prop.type == 'text'">
                        <input type="text" :id="prop.name" v-model="meta[prop.name]" class="form-control">
                    </template>
                    <template v-if="prop.type == 'number'">
                        <input type="number" :id="prop.name" v-model="meta[prop.name]" class="form-control">
                    </template>
                    <template v-if="prop.type == 'checkbox'">
                        <div class="form-check form-switch">
                            <input class="form-check-input" v-model="meta[prop.name]" type="checkbox" role="switch" :id="prop.name">
                            <label class="form-check-label" for="flexSwitchCheckDefault">{{prop.label}}</label>
                        </div>
                    </template>
                    <template v-if="prop.type == 'color'">
                        <select :id="prop.name"  class="form-control color" v-model="meta[prop.name]">
                            <option v-for="op in prop.optionList" :style="`background: ${op.value} ;`" :value="op.value"> {{op.title}} </option>
                        </select>
                    </template>
                    <template v-if="prop.type == 'select' || prop.type == 'singemulti'">
                        <select :id="prop.name"  class="form-control color" v-model="meta[prop.name]">
                            <option v-for="op in prop.optionList"  :value="op.value"> {{op.title}} </option>
                        </select>
                    </template>
                    <template v-if="prop.type == 'multi'">
                        <searchable-multi-select :items="prop.optionList" value-field="value" v-model="meta[prop.name]"></searchable-multi-select>
                    </template>
                </template>
            </div>
        </div>
        <input type="hidden" name="meta" :value="JSON.stringify(meta)">
    </div>
</template>

<script>

import {mapState} from "vuex";
import searchableMultiSelect from "./SearchableMultiSelect.vue";

export default {
    name: "meta-input",
    components: {
        searchableMultiSelect
    },
    data: () => {
        return {
            properties: [],
            meta:{}
        }
    },
    props: {
        propsApiLink:{
            required: true,
        },
        metaz:{
            default: [],
        }
    } ,
    mounted() {
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
    },
    methods: {
        async updateProps(){
            try {
                const  url = this.propsApiLink +  this.category_id;
                let resp = await  axios.get(url);
                this.properties = resp.data.data;
                // added don't have
                for( const prop of this.properties) {
                    if (this.meta[prop.name] == undefined){
                        if (prop.type == 'multi'){
                            this.meta[prop.name] = [];
                        }else{
                            this.meta[prop.name] = '';
                        }
                    }
                }

                // update by old meta data
                for( const meta in this.metaz) {
                  this.meta[meta] = this.metaz[meta];
                }



            } catch(e) {
                window.$toast.error(e.message);
            }

        },
    },
    watch: {
        category_id: function() {
            this.updateProps();
        }
    }
}
</script>

<style scoped>
#meta-input {

}
.color option{

}
</style>
