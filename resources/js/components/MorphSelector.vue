<template>
    <div class="morph-selector">
        <div v-if="this.morph != null && this.id != null">
            {{ humanReadableMorph(morph) }}: [{{ id }}]
        </div>
        <select class="form-control mt-2" v-model="morph" @change="updateList">
            <option :value="null"> Module</option>
            <option v-for="m in morphs" :value="m"> {{ humanReadableMorph(m) }}</option>
        </select>
        <label id="q" class="mt-2">
            Search
            <!-- WIP : translate-->
        </label>
        <input @input="updateList" type="text" id="q" v-model="q" class="form-control" placeholder="search">
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
            <input type="hidden" :value="morph" :name="xnameType">
            <input type="hidden" :value="id" :name="xnameId">
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
        emits: ['update:modelType', 'update:modelId'],
        modelType: {
            default: 'noting',
            type: String,
        },
        modelId: {
            default: 'noting',
            type: String,
        },
        xnameType: {
            default: 'attachable_type'
        },
        xnameId: {
            default: 'attachable_id'
        },
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
        if (this.modelType == 'noting' || this.modelType == 'noting') {

            if (this.xmorph != null && this.xmorph != 'null' && this.xmorph != '') {
                this.morph = this.xmorph;
            }
            if (this.xid != null && this.xid != 'null' && this.xid != '') {
                this.id = parseInt(this.xid);
            }
        } else {
            this.morph = this.modelType;
            this.id = this.modelId;
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
        },


    },
    watch: {
        morph(newValue) {
            if (this.modelType != 'noting') {
                this.$emit('update:modelType', newValue);
            }
        },
        id(newValue) {
            if (this.modelId != 'noting' && newValue != null) {
                this.$emit('update:modelId', newValue.toString());
            }
        },
    }
}
</script>

<style scoped>
.morph-selector .list-group {
    gap: var(--spacing-3xs);
    padding: var(--spacing-2xs);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    background-color: var(--color-surface-raised);
    box-shadow: var(--shadow-md);
}

.morph-selector .list-group-item {
    display: flex;
    align-items: center;
    min-block-size: var(--control-height-xs);
    padding-block: var(--spacing-2xs);
    padding-inline: var(--spacing-sm);
    border: 0;
    border-radius: var(--radius-sm);
    background-color: transparent;
    color: var(--color-text);
    font-size: var(--font-size-sm);
    cursor: pointer;
}

.morph-selector .list-group-item:hover {
    background-color: var(--color-hover);
}

.morph-selector .list-group-item.selected {
    background-color: var(--color-primary-subtle);
    color: var(--color-primary-text);
    font-weight: var(--font-weight-medium);
}

.morph-selector .list-group-item:focus-visible {
    outline: 2px solid var(--color-focus-ring);
    outline-offset: 2px;
}
</style>
