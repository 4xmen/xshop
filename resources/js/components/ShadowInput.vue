<template>
    <div id="shadow-input">
        <div class="row">
            <div class="col-10">
                <input type="range" class="form-range" v-model="x" min="-99" max="99">
            </div>
            <div class="col-2 text-end">
                X: {{ x }}
            </div>
        </div>
        <div class="row">
            <div class="col-10">
                <input type="range" class="form-range" v-model="y" min="-99" max="99">
            </div>
            <div class="col-2 text-end">
                Y: {{ y }}
            </div>
        </div>
        <div class="row">
            <div class="col-9">
                <input type="range" class="form-range" v-model="blur" min="0" max="50">
            </div>
            <div class="col-3 text-end">
                Blur: {{ blur }}
            </div>
        </div>
        <div class="row">
            <div class="col-9">
                <input type="color" class="form-control-color" v-model="color" >
            </div>
            <div class="col-3 text-end">
                Color
            </div>
        </div>
        <input type="hidden" :value="calcVal">
    </div>
</template>

<script>
export default {
    name: "shadow-input",
    components: {},
    data: () => {
        return {
            x: 0,
            y: 0,
            blur: 0,
            color: '#dddddd',
            mounted : false,
        }
    },
    emits: ['update:modelValue'],
    props: {
        modelValue: {
            default: '2px 2px 4px #ff0000'
        }
    },
    mounted() {
        let spltd = this.modelValue.trim().split(' ');
        console.log(spltd);
        this.x = parseInt(spltd[0]);
        this.y = parseInt(spltd[1]);
        this.blur = parseInt(spltd[2]);
        this.color = spltd[3];
        this.mounted = true;
    },
    computed: {
        calcVal() {
            if (!this.mounted){
                return '';
            }
            let result = this.x+'px '+this.y+'px '+this.blur+'px '+this.color;
            this.$emit('update:modelValue', result);
            return result.trim();
        }
    },
    methods: {}
}
</script>

<style scoped>
#shadow-input {

}
</style>
