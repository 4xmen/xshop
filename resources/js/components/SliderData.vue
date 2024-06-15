<template>
    <div id="slider-data">
        <div class="row">
            <div class="col-4">
                Keys:
            </div>
            <div class="col-8">
                Values:
            </div>
        </div>
        <div class="row mt-2" v-for="(val,i) in values">
            <div class="col-4  px-1">
                <input type="text" placeholder="key" v-model="val.key" class="form-control">
            </div>
            <div class="col-6  px-1">
                <input type="text" placeholder="value" v-model="val.value" class="form-control">
            </div>
            <div class="col-2 text-center px-1">
                <button class="btn btn-danger btn-sm" @click="remValue(i)" type="button">
                    <i class="ri-close-line"></i>
                </button>
            </div>
        </div>
        <br>
        <button class="btn btn-secondary w-100" @click="addValue" type="button">
            <i class="ri-add-line"></i>
        </button>
        <input type="hidden" name="data" :value="JSON.stringify(values)" >
    </div>
</template>

<script>
export default {
    name: "slider-data",
    components: {},
    data: () => {
        return {
            values:[]
        }
    },
    props: {
        dataz:{
            type: Array,
            default: [],
        }
    },
    mounted() {
        this.values = this.dataz;
    },
    computed: {
    },
    methods: {
        addValue(){
            this.values.push({
                'key' : 'key' + (this.values.length + 1),
                'value' : '',
            });
        },
        remValue(i){
            if (confirm('Are you sure?')){
                this.values.splice(i,1);
            }
        }
    }
}
</script>

<style scoped>
#slider-data {
    padding: 1rem;
}
</style>
