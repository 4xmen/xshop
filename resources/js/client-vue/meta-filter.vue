<template>
    <div id="meta-filter">
        <form action="#product-list-view" id="filter-form" ref="frm">

            <ul>
                <li>
                    <div class="form-check form-switch">
                        <input class="form-check-input" value="1" type="checkbox" v-model="only" role="switch" id="flexSwitchCheckDefault"
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
            </ul>
            <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                Apply filter
            </button>
        </form>

    </div>
</template>

<script>

function getUrlVars()
{
    var foo = window.location.href.split('?')[1].split('#')[0].split('&');
    var dict = {};
    var elem = [];
    for (var i = foo.length - 1; i >= 0; i--) {
        elem = foo[i].split('=');
        dict[elem[0]] = elem[1];
    }
    return dict;
}
export default {
    name: "meta-filter",
    components: {},
    data: () => {
        return {
            inited: false,
            only: false,
            sort: '',
        }
    },
    props: {},
    mounted() {
        let gets = getUrlVars();
        console.log(gets);
        for( const get in gets) {
            if (typeof(this[get]) == 'boolean'){
                if (gets[get] == '1'){
                    this[get] = true;
                }
            }else{

               this[get] = gets[get];
            }
        }

        console.log(this.only);
        setTimeout( () => {
            this.inited = true;
        },100);

    },
    computed: {

    },
    methods: {
        apply() {
            this.$refs.frm.submit();
        },
    },
    watch:{
        only(){
            if (this.inited){
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
