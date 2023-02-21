<template>
    <input type="text" :class="classes" @keyup="fix" @input="handleInput" :id="id" v-model="content" :name="name" :placeholder="placeholder"/>
</template>

<script>

export default {
    name: "CurrencyInput",
    props:['id','classes','name','value','placeholder'],
    data () {
        return {
            content: this.value
        }
    },
    methods: {
        handleInput (e) {
            this.$emit('input', this.nocomma(this.content));
        },
        fix:function () {
            this.content = this.commafy(this.content);
            this.$emit('keyup');
        },
        nocomma: function (num) {
            let a = num.replace(/\,/g, ''); // 1125, but a string, so convert it to number
            return a.toString();
        },
        commafy: function (num) {
            num = this.nocomma(num);
            var str = num.toString().split('.');
            if (str[0].length >= 4) {
                str[0] = str[0].replace(/(\d)(?=(\d{3})+$)/g, '$1,');
            }
            if (str[1] && str[1].length >= 4) {
                str[1] = str[1].replace(/(\d{3})/g, '$1,');
            }
            return str.join('.');
        },
    }
}
</script>

<style scoped>

</style>
