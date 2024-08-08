<template>
    <div class="quantity">
        <div class="val">
            {{val}}
        </div>
        <div class="border-end-0 btns">
            <i class="ri-arrow-up-s-line"
               @mousedown="startIncrement"
               @mouseup="stopChange"
               @mouseleave="stopChange"></i>
            <i class="ri-arrow-down-s-line"
               @mousedown="startDecrement"
               @mouseup="stopChange"
               @mouseleave="stopChange"></i>
        </div>
        <input type="hidden" :name="xname" v-if="xname != null" :value="val">
    </div>
</template>

<script>
export default {
    name: "quantity",
    data: () => ({
        val: 1,
        interval: null,
        timeout: null,
        changeSpeed: 100, // milliseconds between each change
        startDelay: 1000, // 1 second delay before rapid change starts
    }),
    emits: ['update:modelValue'],
    props: {
        min: {
            default: 1,
            type: Number,
        },
        max: {
            default: 99,
            type: Number,
        },
        xname: {
            default: null,
            type: [null, String],
        },
        modelValue: {
            type: Number,
            default: 1,
        },
    },
    methods: {
        inc() {
            if (this.val < this.max) {
                this.val++;
                this.$emit('update:modelValue', this.val);
            }
        },
        dec() {
            if (this.val > this.min) {
                this.val--;
                this.$emit('update:modelValue', this.val);
            }
        },
        startIncrement() {
            this.inc(); // Immediate first increment
            this.timeout = setTimeout(() => {
                this.interval = setInterval(this.inc, this.changeSpeed);
            }, this.startDelay);
        },
        startDecrement() {
            this.dec(); // Immediate first decrement
            this.timeout = setTimeout(() => {
                this.interval = setInterval(this.dec, this.changeSpeed);
            }, this.startDelay);
        },
        stopChange() {
            clearTimeout(this.timeout);
            clearInterval(this.interval);
        },
    },
    beforeUnmount() {
        this.stopChange();
    },
}
</script>

<style scoped>
.quantity {
    direction: ltr;
    border: 1px solid rgba(128, 128, 128, 0.56);
    display: grid;
    grid-template-columns: 2fr 1fr;
    width: 90px;
    height: 50px;
    border-radius: var(--xshop-border-radius);

    .val{
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    i{
        display: block;
        transition: 377ms;

        &:first-child{
            border-bottom:  1px solid rgba(128, 128, 128, 0.56);
        }

        &:hover{
            background: var(--xshop-primary);
            color: var(--xshop-diff);
        }
    }

    .btns{
        border: 1px solid rgba(128, 128, 128, 0.56);
        border-bottom: 0;
        border-top: 0;
        text-align: center;
    }
}
</style>
