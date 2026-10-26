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
#shadow-input .row {
    align-items: center;
}

#shadow-input .text-end {
    color: var(--color-text-muted);
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-medium);
    font-variant-numeric: tabular-nums;
}

.cir-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    inline-size: var(--control-height-xs);
    block-size: var(--control-height-xs);
    padding: 0;
    border: 1px solid var(--color-border-strong);
    border-radius: var(--radius-full);
    background-color: transparent;
    color: var(--color-text-muted);
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-medium);
    cursor: pointer;
}

.cir-btn:hover {
    background-color: var(--color-hover);
    color: var(--color-text);
}

.cir-btn.active {
    border-color: var(--color-primary-edge);
    background-color: var(--color-primary);
    color: var(--color-text-on-primary);
}

.cir-btn:focus-visible {
    outline: 2px solid var(--color-focus-ring);
    outline-offset: 2px;
}

.form-range::-webkit-slider-runnable-track {
    background-color: var(--color-field);
    box-shadow: inset 0 0 0 1px var(--color-border);
}

.form-range::-moz-range-track {
    background-color: var(--color-field);
    box-shadow: inset 0 0 0 1px var(--color-border);
}

.form-range::-webkit-slider-thumb {
    background-color: var(--color-primary-text);
}

.form-range::-webkit-slider-thumb:active {
    background-color: var(--color-primary-hover);
}

.form-range::-moz-range-thumb {
    background-color: var(--color-primary-text);
}

.form-range::-moz-range-thumb:active {
    background-color: var(--color-primary-hover);
}

.form-range:focus::-webkit-slider-thumb {
    box-shadow: none;
}

.form-range:focus::-moz-range-thumb {
    box-shadow: none;
}

.form-range:focus-visible {
    border-radius: var(--radius-sm);
    outline: 2px solid var(--color-focus-ring);
    outline-offset: 2px;
}
</style>
