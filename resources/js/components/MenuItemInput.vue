<template>
    <div class="menu-item">

        <div v-for="(item,i) in currentItems" :key="i">
            <div class="card">

                <div class="card-header">
                    Menu item {{ i + 1 }}
                </div>
                <div class="card-body">
                    <div class="row p-0">
                        <div class="col-md-11">
                            <div>
                                <!-- WIP translate-->
                                <label :for="`kind-${i}`">
                                    Kind
                                </label>
                                <select v-model="item.kind" class="form-control" :id="`kind-${i}`">
                                    <option :value="null"> Kind</option>
                                    <option :value="kind" v-for="kind in kinds"> {{ kind }}</option>
                                </select>
                            </div>
                            <div v-if="item.kind == 'module'">
                                <label :for="`title2-${i}`">
                                    Title
                                </label>

                                <input type="text" v-model="item.title" placeholder="Title" class="form-control"
                                       :id="`title2-${i}`">
                                <morph-selector
                                    xname-type=""
                                    xname-id=""
                                    :morph-search-link="this.morphSearchLink"
                                    :morphs="morphs"
                                    :xlang="this.xlang"
                                    v-model:model-id="item.menuable_id"
                                    v-model:model-type="item.menuable_type"
                                >
                                </morph-selector>
                            </div>
                            <div v-else-if="item.kind == 'direct'">
                                <div class="row pt-2">
                                    <div class="col-md p-0 pe-2">
                                        <label :for="`title1-${i}`">
                                            Title
                                        </label>
                                        <input type="text" v-model="item.title" placeholder="Title" class="form-control"
                                               :id="`title1-${i}`">
                                    </div>
                                    <div class="col-md p-0">
                                        <label :for="`meta-${i}`">
                                            Link
                                        </label>
                                        <input type="text" v-model="item.meta" placeholder="Link" class="form-control"
                                               :id="`meta-${i}`">
                                    </div>
                                </div>
                            </div>
                            <div v-else class="py-2">
                                <div class="alert bg-danger">
                                    Please select kind
                                </div>
                            </div>
                        </div>
                        <div class="col-md d-flex justify-content-center align-items-center">
                            <button type="button" class="btn btn-primary" @click="remItem(i)">
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-primary my-3" @click="addItem">
            <i class="ri-add-line"></i>
        </button>
        <input type="hidden" name="items" :value="JSON.stringify(this.currentItems)">
        <input type="hidden" name="removed" :value="JSON.stringify(this.removed)">
    </div>
</template>

<script>

import MorphSelector from "./MorphSelector.vue";

export default {
    name: "menu-item",
    components: {MorphSelector},
    data: () => {
        return {
            currentItems: [],
            removed: [],
            kinds: [
                'direct',
                'module'
            ],
        }
    },
    props: {
        morphs: {
            default: [],
        },
        xlang: {
            default: null,
        },
        morphSearchLink: {
            default: null,
        },
        items: {
            default: []
        },
        menuId: {
            required: true,
        }
    },
    mounted() {
        let tmp = [];
        for (const i in this.items) {

            if (typeof (this.items[i].title) != 'undefined') {
                tmp[i] = {...this.items[i]};
                tmp[i].title = this.items[i].title[this.xlang];
            }
        }

        this.currentItems = tmp;
    },
    computed: {},
    methods: {
        addItem() {
            this.currentItems.push({
                id: null,
                title: null,
                menuable_id: null,
                menuable_type: null,
                kind: 'direct',
                sort: this.currentItems.length,
                parent: null,
                menu_id: this.menuId,
            });
        },
        remItem(i) {
            if (this.currentItems[i].id != null) {
                this.removed.push(this.currentItems[i].id);
            }
            this.currentItems.splice(i, 1)
        }

    }
}
</script>

<style scoped>
.menu-item {
    padding-right: 1rem;
    padding-left: 1rem;
}
.menu-item .card{
    margin-bottom: 1rem;
}
.menu-item .card-body{
    background: #ffffff11;
}
</style>
