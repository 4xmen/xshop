<template>
    <div id="morph-selector">
        <div v-if="this.morph != null && this.id != null">
            {{ humanReadableMorph(morph) }}: [{{ id }}]
        </div>
        <select class="form-control" v-model="morph" @change="updateList">
            <option v-for="m in morphs" :value="m"> {{ humanReadableMorph(m) }}</option>
        </select>
        <label id="q" class="mt-2">
            Search
            <!-- WIP : translate-->
        </label>
        <input @input="updateList" type="text" id="q" v-model="q" class="form-control">
        <div v-if="all.length > 0">

            <ul class="list-group my-2">
                <template v-for="item in all">
                    <li :class="`list-group-item `+(id == item.id?'selected':'') " @click="selectId(item.id)">

                        <template v-if="item.name != undefined">
                            <template v-if="xlang == null">
                                {{ item.name }}
                            </template>
                            <template v-else>
                                {{ item.name[xlang] }}
                            </template>
                        </template>
                        <template v-if="item.title != undefined">
                            <template v-if="xlang == null">
                                {{ item.title }}
                            </template>
                            <template v-else>
                                {{ item.title[xlang] }}
                            </template>
                        </template>
                    </li>
                </template>
            </ul>
        </div>
        <div v-if="this.morph != null && this.id != null">
            <input type="hidden" :value="morph" name="attachable_type">
            <input type="hidden" :value="id" name="attachable_id">
        </div>
    </div>
</template>

<script>
export default {
    name: "morph-selector",
    components: {},
    data: () => {
        return {
            morph: null,
            q: '',
            all: [],
            id: null,

        }
    },
    props: {
        morphs: {
            default: [],
        },
        morphSearchLink: {
            default: null,
        },
        xlang: {
            default: null
        },
        xid: {
            default: null,
        },
        xmorph: {
            default: null,
        }
    },
    mounted() {
        if (this.xmorph != null && this.xmorph != 'null' && this.xmorph != '') {
            this.morph = this.xmorph;
        }
        if (this.xid != null && this.xid != 'null' && this.xid != '') {
            this.id = parseInt(this.xid);
        }
    },
    computed: {},
    methods: {
        selectId(i) {
            this.id = i;
        },
        async updateList() {
            this.id = null;
            const url = this.morphSearchLink;
            if (url != null) {
                let res = await axios.post(url, {
                    morph: this.morph,
                    q: this.q,
                });
                if (res.data.OK) {
                    this.all = res.data.data;
                }
            }
        },
        humanReadableMorph(morph) {
            const tmp = morph.split('\\');
            return tmp[tmp.length - 1];
        }
    }
}
</script>

<style scoped>
#morph-selector {

}

.list-group-item.selected {
    background: darkred;
}
</style>
