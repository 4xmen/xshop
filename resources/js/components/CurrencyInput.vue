<template>
    <div id="currency">
        <input @keyup="keyup" :id="xid" :placeholder="xtitle" :class="getClass" type="text" v-model="val">
        <input type="hidden" :name="xname" :value="noComma">
    </div>
</template>
<script>

function commafy(num) {
    if (typeof num !== 'string') {
        return '';
    }
    let str = uncommafy(num.toString()).split('.');
    if (str[0].length >= 5) {
        str[0] = str[0].replace(/(\d)(?=(\d{3})+$)/g, '$1,');
    }
    if (str[1] && str[1].length >= 5) {
        str[1] = str[1].replace(/(\d{3})/g, '$1 ');
    }
    return str.join('.');
}

function uncommafy(txt) {
    return txt.split(',').join('');
}

export default {
    name: "curency-input",
    components: {},
    data: () => {
        return {
            val: ''
        }
    },
    emits: ['update:modelValue'],
    props: {
        modelValue: {
            type: [Number, String],
            default: 'nop',
        },
        xname: {
            default: "",
            type: String,
        },
        xtitle: {
            default: "",
            type: String,
        },
        xvalue: {
            default: "",
            type: String,
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

        updateKey: {
            default: function () {

            },
            type: Function,
        },

    },
    mounted() {


        if (this.modelValue !== 'nop') {

            if (typeof this.modelValue == 'number') {
                this.val = commafy(this.modelValue.toString());
            } else {
                this.val = commafy(this.modelValue);
            }
        } else {

            if (typeof this.xvalue == 'number') {
                this.val = commafy(this.xvalue.toString());
            } else {
                this.val = commafy(this.xvalue);
            }
        }


    },
    computed: {
        noComma: function () {
            const n = uncommafy(this.val);
            // if (this.modelValue != 'nop') {
            //     this.$emit('update:modelValue', n);
            // }
            return n;
        },
        getClass: function () {
            if (this.err == true || (typeof this.err == 'String' && this.err.trim() == '1')) {
                return 'form-control is-invalid ' + this.customClass;
            }
            return 'form-control ' + this.customClass;
        },
    },
    methods: {
        keyup: function () {
            this.val = commafy(this.val);
            this.$emit('update:modelValue', this.noComma);
            if (typeof this.update === 'function') {
                this.update(this.updateKey, parseInt(this.noComma));
            }
        },
    },
    watch: {
        val(newValue) {
            if (this.modelValue !== 'nop') {
                this.$emit('update:modelValue', uncommafy(newValue));
            }
        }
    }
}
</script>

<style scoped>

</style>
