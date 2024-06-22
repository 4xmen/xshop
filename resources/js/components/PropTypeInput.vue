<template>
    <div id="prop-type-input">
        <div class="row">
            <div class="col-md-8 px-0 mt-2">
                <select :id="xid" :class="getClass" v-model="val" :name="xname"  :required="isRequired">
                    <option value=""> {{ xtitle }}</option>
                    <option v-for="t in types"
                            :value="t"
                            :selected="t == val">
                        {{ t }}
                    </option>
                </select>
            </div>
            <div class="col-md-4 px-0 ps-lg-2 ps-xl-2 ps-xxl-2 mt-2" v-if="val == 'select' || val == 'multi' || val == 'singlemulti' || val =='color'">
                <button type="button" class="btn btn-outline-info w-100" @click="addItem">
                    <i class="ri-add-line"></i>
                </button>
            </div>
        </div>

        <div id="extra-data" v-if="val == 'select' || val == 'multi' || val == 'singlemulti' || val =='color'">
            <div v-for="(item,i) in items" class="row pb-1 mb-0">
                <div class="col-md-6 mt-2">
                    <input type="text"  placeholder="Title" class="form-control" v-model="item.title">
                </div>
                <div class="col-md-5 mt-2">
                    <div v-if="val == 'color'">
                        <input type="color" class="form-control" style="height: 37px" v-model="item.value">
                    </div>
                    <div v-else-if="val == 'select' || val == 'multi' || val == 'singlemulti'">
                        <input type="text"  placeholder="Value" class="form-control" v-model="item.value">
                    </div>

                </div>
                <div class="col-md-1 text-center mt-2">
                    <button type="button" @click="remItem(i)" class="btn btn-danger w-100">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
            </div>

        </div>
        <input type="hidden" :name="xoptionname" :value="jsonItem">
    </div>
</template>

<script>
export default {
    name: "prop-type-input",
    components: {},
    data: () => {
        return {
            val: null,
            items: [],
        }
    },
    emits: ['update:modelValue'],
    props: {
        types: {
            required: true,
            type: Array,
        },
        modelValue: {
            type: [Number, String],
            default: 'nop',
        },
        xname: {
            default: "",
            type: String,
        },
        xoptionname:{
          default: 'options',
        },
        xtitle: {
            default: "",
            type: String,
        },
        xvalue: {
            default: "",
            type: String,
        },
        xoptions: {
            default:[],
        },
        xid: {
            default: "",
            type: String,
        },
        customClass: {
            default: "",
            type: String,
        },
        err: {
            default: false,
            type: Boolean,
        },
        isRequired:{
            default: false,
            type: Boolean,
        },
    },
    mounted() {
        // console.log(this.types);
        if (!isNaN(this.modelValue)) {
            this.val = this.modelValue;
        } else {
            this.val = this.xvalue;
        }

        this.items = this.xoptions;
        // console.log(this.val);
    },
    computed: {
        getClass: function () {
            if (this.err == true || (typeof this.err == 'String' && this.err.trim() == '1')) {
                return 'form-control is-invalid ' + this.customClass;
            }
            return 'form-control ' + this.customClass;
        },
        jsonItem(){
            let itms = [];
            for( const i of this.items) {
              if (i.value != '' && i.title != ''){
                  itms.push(i);
              }
            }
            // if (itms.length == 0){
            //     return  null;
            // }

            return JSON.stringify(itms);
        }
    },
    methods: {
        addItem(){
            let value = '';
            if (this.val == 'color'){
                value = '#ff0000';
            }
            this.items.push({
                title : '',
                value: value
            });
        },
        remItem(i){
            if (!confirm('Are you sure?')){ // WIP: translate
                return false;
            }
            this.items.splice(i,1);
        }
    }
}
</script>

<style scoped>
#prop-type-input {

}
</style>
