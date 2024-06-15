<template>
    <div id="example">
        <div class="p-2">
            <currency-input v-model="p"></currency-input>
            <span>
                {{ p }}
            </span>
        </div>
        <div class="p-2">
            <font-awesome-icon-picker v-model="f"></font-awesome-icon-picker>
            <span>
                {{ f }}
            </span>
        </div>
        <div class="p-2">
            <remix-icon-picker v-model="r"></remix-icon-picker>
            <span>
                {{ r }}
            </span>
        </div>

        <div class="p-2">
            <searchable-multi-select :items="cats" v-model="mss"></searchable-multi-select>
            <span>
                {{ mss }}
            </span>
        </div>
        <div class="p-2">
            <vue-date-range-picker  v-model="dpr"></vue-date-range-picker>
            <span>
                {{ dpr }}
            </span>
        </div>
        <div class="p-2">
            <vue-date-time-picker v-model="dp"></vue-date-time-picker>
            <span>
                {{ dp }}
            </span>
        </div>
        <div class="p-2">
            <vue-date-time-picker v-model="dpt" :timepicker="true"></vue-date-time-picker>
            <span>
                {{ dpt }}
            </span>
        </div>
        <div class="p-2">
           <increment v-model="i"></increment>
            <span>
                {{ i }}
            </span>
        </div>

    </div>
</template>

<script>
import CurrencyInput from "./CurrencyInput.vue";
import fontAwesomeIconPicker from "./FontAwesomeIconPicker.vue";
import remixIconPicker from "./RemixIconPicker.vue";
import searchableSelect from "./SearchableSelect.vue";
import SearchableMultiSelect from "./SearchableMultiSelect.vue";
import vueDateTimePicker from "./vueDateTimePicker.vue";
import vueDateRangePicker from "./vueDateRangePicker.vue";
import Increment from "./Increment.vue";
export default {
    name: "example",
    components: {
        CurrencyInput, fontAwesomeIconPicker, remixIconPicker,Increment,
        searchableSelect, SearchableMultiSelect, vueDateRangePicker, vueDateTimePicker
    },
    data: () => {
        return {
            p: 100000,
            f: 'fa fa-user',
            r: 'ri-user-line',
            ss: 3,
            mss: [3,11,7],
            dpr:[],
            dp: null,
            dpt: null,
            i:7,
        }
    },
    props: {
        cats: {
            default: [],
        }
    },
    mounted() {
    },
    computed: {},
    methods: {}
}
</script>

<style scoped>
#example {

}
</style>
