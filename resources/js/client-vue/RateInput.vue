<template>
    <div id="rate-input">
            <div class="float-end" @mouseleave="hoverIndex = 0">
                <template v-for="i in 5">
                    <i :class="hoverClass(i)" @mouseenter="hovering(i)" @click="val = i"></i>
                </template>
            </div>
            <div class="p-2">
                {{this.xtitle}}
            </div>
    </div>
    <input type="hidden" :name="xname" v-model="val">
</template>

<script>
export default {
    name: "rate-input",
    components: {},
    data: () => {
        return {
            hoverIndex: 0,
            val: 0,
        }
    },
    props: {
        xtitle:{
            default: 'rate',
            type: String,
        },
        xname:{
            default:  null,
        },
        xvalue:{
            default: 0,
        },
    },
    mounted() {
        this.val = this.xvalue;
    },
    computed: {},
    methods: {
        hovering(i) {
            this.hoverIndex = i;
        },
        hoverClass(i) {
            if (this.hoverIndex >= i) {
                return 'ri-star-fill';
            } else {
                if (this.val >= i){
                    return 'ri-star-fill selected';
                }
                return 'ri-star-line';
            }
        },
    }
}
</script>

<style scoped>
#rate-input {

    i {
        cursor: pointer;
        font-size: 25px;
        color: gray;
        transition: 250ms;
    }

    .ri-star-fill {
        color: goldenrod;

        &.selected{
            color:var(--xshop-primary);
        }
    }
}

</style>
