<template>
    <div id="inc">
        <div class="btn btn-outline-danger" @click="dec">
            <i class="ri-subtract-line"></i>
        </div>
        <input type="text" class="form-control"
               :name="xname"
               v-model="val"
               @keyup.up="inc"
               @keyup.down="dec">
        <div class="btn btn-outline-success" @click="inc">
            <i class="ri-add-line"></i>
        </div>
    </div>
</template>

<script>
export default {
    name: "inc",
    components: {},
    data: () => {
        return {
            val: 0,
        }
    },
    emits: ['update:modelValue'],
    props: {
        modelValue: {
            type: [Number, NaN],
            default: NaN,
        },
        xvalue: {
            type: Number,
            default: 0
        },
        xmin: {
            type: Number,
            default: 0
        },
        xmax: {
            type: Number,
            default: 100
        },
        xname:{
            type: String,
            default: '',
        }
    },
    mounted() {
        if (!isNaN(this.modelValue)) {
            this.val = this.modelValue;
        }else{
            this.val = parseInt(this.xvalue.toString());
        }
    },
    computed: {},
    methods: {
        inc(e){
            e.preventDefault();
            if (this.val < this.xmax){
                this.val++;
            }
        },
        dec(e){
            e.preventDefault();
            if (this.val > this.xmin){
                this.val--;
            }
        }
    },
    watch: {
        val(newValue) {
            if (parseInt(this.val) > this.xmax){
                this.val = this.xmax;
            }
            if (parseInt(this.val) < this.xmin){
                this.val = this.xmin;
            }
            if (!isNaN(this.modelValue)) {
                this.$emit('update:modelValue', newValue);
            }
        }
    }
}
</script>

<style scoped>
#inc {
    display: grid;
    grid-template-columns: 1fr 2fr 1fr;
    direction: ltr;
}

#inc .form-control {
    border-radius: 0;
    text-align: center;
}

#inc div:first-child {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    user-select: none;
}

#inc div:last-child {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    user-select: none;
}
</style>
