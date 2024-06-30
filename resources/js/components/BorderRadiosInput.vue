<template>
    <div id="border-radios-input">
        <div id="shadow-input">

            <div class="row mb-2">
                <template v-for="i in 4">
                    <div class="col text-center" v-if="i != 3">
                        <button type="button" :class="`cir-btn `+(i == count?'active':'')" @click="count = i">
                            {{ i }}
                        </button>
                    </div>
                </template>
            </div>
            <div class="row">
                <div class="col-10">
                    <input type="range" class="form-range" v-model="val1" min="0" max="99">
                </div>
                <div class="col-2 text-end">
                    {{ val1 }}
                </div>
            </div>
            <div v-if="count > 1" class="row">
                <div class="col-10">
                    <input type="range" class="form-range" v-model="val2" min="0" max="99">
                </div>
                <div class="col-2 text-end">
                    {{ val2 }}
                </div>
            </div>
            <div v-if="count > 2" class="row">
                <div class="col-10">
                    <input type="range" class="form-range" v-model="val3" min="0" max="99">
                </div>
                <div class="col-2 text-end">
                    {{ val3 }}
                </div>
                <div class="col-10">
                    <input type="range" class="form-range" v-model="val4" min="0" max="99">
                </div>
                <div class="col-2 text-end">
                    {{ val4 }}
                </div>
            </div>

            <input type="hidden" :value="calcVal">

        </div>
    </div>
</template>

<script>
export default {
    name: "border-radios-input",
    components: {},
    data: () => {
        return {
            count: 0,
            val1: 0,
            val2: 0,
            val3: 0,
            val4: 0,
        }
    },
    emits: ['update:modelValue'],
    props: {
        modelValue: {
            default: '7px'
        }
    },
    mounted() {
        // setTimeout(()=>{
            let spltd = this.modelValue.trim().split(' ');
            this.count = spltd.length;
            // make valid
            for (const s in spltd) {
                spltd[s] = parseInt(spltd[s]);
                this['val' + (parseInt(s) + 1)] = parseInt(spltd[s]);
            }
        // },30);
    },
    computed: {
        calcVal() {
            let result;
            if (this.count == 0){
                return '';
            }
            if (this.count == 1) {
                result = this.val1 + 'px';
            } else if (this.count == 2) {
                result = this.val1 + 'px ' + this.val2 + 'px';
            }else if (this.count == 4) {
                result = this.val1 + 'px ' + this.val2 + 'px ' +this.val3 + 'px ' + this.val4 + 'px';
            }

            this.$emit('update:modelValue', result);
            return result.trim();
        }
    },
    methods: {}
}
</script>

<style scoped>
#border-radios-input {

}

.cir-btn {
    background: transparent;
    font-size: 17px;
    border: 1px solid gray;
    width: 35px;
    height: 35px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    padding-top: 3px;

    &.active {
        background: darkred;
    }
}
</style>
