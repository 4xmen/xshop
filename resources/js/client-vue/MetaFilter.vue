<template>
    <div id="meta-filter">
        <form action="#product-list-view" id="filter-form" ref="frm">

            <ul>
                <li>
                    <div class="form-check form-switch">
                        <input class="form-check-input" value="1" type="checkbox" v-model="only" role="switch"
                               id="flexSwitchCheckDefault"
                               name="only">
                        <label class="form-check-label" for="flexSwitchCheckDefault">
                            <!-- WIP translate -->
                            Only available
                        </label>
                    </div>
                </li>
                <li>
                    <label>
                        Sort by
                    </label>
                    <select name="sort" v-model="sort" class="form-control">
                        <option value="">
                            Newest
                        </option>
                        <option value="oldest">
                            Oldest
                        </option>
                        <option value="cheap">
                            Cheaper
                        </option>
                        <option value="expensive">
                            More expensive
                        </option>
                        <option value="fav">
                            Favorite
                        </option>
                        <option value="sale">
                            More sale
                        </option>
                    </select>
                </li>
                <template v-for="(prop,i) in props">
                    <li v-if="prop.searchable" :key="i">
                        <label :for="`prop-${i}`" v-if="prop.type != 'checkbox'">
                            {{ prop.label }}
                        </label>
                        <template v-if="prop.type == 'checkbox'">
                            <div class="form-check form-switch">
                                <input class="form-check-input" :name="`meta[${prop.name}]`" type="checkbox"
                                       role="switch"
                                       :id="`prop-${i}`">
                                <label class="form-check-label" :for="`prop-${i}`">{{ prop.label }}</label>
                            </div>
                        </template>
                        <template v-if="prop.type == 'number'">
                            <input type="number" :id="prop.name" class="form-control" :name="`meta[${prop.name}]`">
                        </template>
                        <template v-if="prop.type == 'color'">
                            <select :id="prop.name" class="form-control color" :name="`meta[${prop.name}]`">
                                <option value=""> All</option>
                                <option v-for="op in prop.optionList" :style="`background: ${op.value} ;`"
                                        :value="op.value"> {{ op.title }}
                                </option>
                            </select>
                        </template>
                        <template v-if="prop.type == 'select'">
                            <select :id="prop.name" class="form-control color" :name="`meta[${prop.name}]`">
                                <option value=""> All</option>
                                <option v-for="op in prop.optionList" :value="op.value"> {{ op.title }}</option>
                            </select>
                        </template>
                        <template v-if="prop.type == 'multi'  || prop.type == 'singemulti'">
                            <searchable-multi-select2 :ref="prop.name" :items="prop.optionList" value-field="value"
                                                     :xname="`meta[${prop.name}]`"
                                                     v-model="metaz[prop.name]"
                            ></searchable-multi-select2>
                        </template>
                    </li>
                </template>
            </ul>
            <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                Apply filter
            </button>
        </form>

    </div>
</template>

<script>
import axios from "axios";
import searchableMultiSelect2 from "./SearchableMultiSelect2.vue";


function extractTextBetweenBrackets(input) {
    const regex = /\[(.*?)\]/g; // Regular expression to match text between []
    const matches = [];
    let match;

    // Loop through all matches found in the input string
    while ((match = regex.exec(input)) !== null) {
        matches.push(match[1]); // Push the captured group into the matches array
    }

    try {
        return matches[0]; // Return an array of matches
    } catch {
        return  null
    }

}

function getUrlVars() {
    try {
        const queryString = window.location.href.split('?')[1]?.split('#')[0];
        if (!queryString) {
            return {};
        }

        const pairs = queryString.split('&');
        const dict = {};

        pairs.forEach(pair => {
            const [key, value] = pair.split('=');
            // Decode the key and value, handling cases where the value is undefined
            dict[decodeURIComponent(key)] = value !== undefined ? decodeURIComponent(value) : '';
        });

        return dict;
    } catch (e) {
        console.log(e.message);
        return {};
    }
}


export default {
    name: "meta-filter",
    components: {searchableMultiSelect2},
    data: () => {
        return {
            inited: false,
            only: false,
            sort: '',
            props: [],
            metaz: {},
        }
    },
    props: {
        category: {
            default: null,
        },
        propsApiLink: {
            required: true,
        },
    },
    async mounted() {

        // get props from category
        if (this.category != null) {
            try {
                const url = this.propsApiLink + this.category;
                let resp = await axios.get(url);


                // initial array multi select v-model
                for( const prop of resp.data.data) {
                    if (prop.type == 'multi'  || prop.type == 'singemulti'){
                        this.metaz[prop.name] = [];
                    }
                }

                // set props after do it
                this.props = resp.data.data;

            } catch (e) {
                console.log(e.message);
            }


        }
        // set def filter value by get query
        let gets = getUrlVars();
        for (const get in gets) {
            if (typeof (this[get]) == 'boolean') {
                if (gets[get] == '1') {
                    this[get] = true;
                }
            } else {

                this[get] = gets[get];

            }
        }

        // for (const p of this.props) {
        //     if (this[p.name] != undefined) {
        //         this.name[p.name] = this[p.name];
        //     }
        // }
        setTimeout(() => {
            this.inited = true;
            let gets = getUrlVars();

            // set default values dynamic filters
            for( const get in gets) {
                if (gets[get] == 'on'){
                    document.querySelector(`[name="${get}"]`).checked = true;
                }else{
                    try {
                        const val = JSON.parse(gets[get]);
                        if (typeof(val) == 'object'){
                            const  k = extractTextBetweenBrackets(get);
                            if (k != null){
                                this.metaz[k] = val;
                                // console.log(this.$refs[k][0],'xx');
                                this.$refs[k][0].val = val;
                            }
                        }else{
                            document.querySelector(`[name="${get}"]`).value = gets[get];
                        }
                    } catch(e) {
                        document.querySelector(`[name="${get}"]`).value = gets[get];
                    }

                }
            }


        }, 300);

    },
    computed: {},
    methods: {
        apply() {
            this.$refs.frm.submit();
        },
    },
    watch: {
        only() {
            if (this.inited) {
                this.apply();
            }
        }
    }
}
</script>

<style scoped>
#meta-filter {
    ul {
        list-style: none;
        padding: 0;

        li {
            padding: .5rem;
            background: #ffffff44;
            margin-bottom: 4px;

            label {
                margin-top: 2px;
            }
        }
    }
}


</style>
