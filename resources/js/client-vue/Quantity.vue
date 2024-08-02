<template>
    <div id="quantity">

    </div>
</template>

<script>
export default {
    name: "quantity",
    components: {},
    data: () => {
        return {
            modelValue: 1,
        }
    },
    props: {
        min:{
            default: 1,
            type: Number,
        },
        max: {
            default: 99,
            type: Number,
        },
        xname:{
            default: null,
            type: null|String,
        },


    },
    mounted() {
    },
    computed: {},
    methods: {}
}
</script>

<style scoped>
#quantity {
    direction: ltr;
    border: 1px solid gray;
}
</style>
