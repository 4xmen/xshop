<template>
    <div id="area-designer">
        <div class="card mt-2" v-for="(part,p) in partsData">
            <div class="card-header">
                Part {{ p + 1 }}
                <span v-if="p !== 0" class="btn btn-secondary btn-sm float-end mx-1" @click="shiftArray(p,-1)">
                    <i class="ri-arrow-up-line"></i>
                </span>
                <span v-if="p != partsData.length - 1" class="btn btn-secondary btn-sm float-end mx-1"
                      @click="shiftArray(p,1)">
                    <i class="ri-arrow-down-line"></i>
                </span>
            </div>
            <div class="part-body">
                <div class="row text-center">
                    <div class="col">
                        <button type="button" class="btn btn-secondary mt-4" @click="activeIndex = p">
                            <i class="ri-edit-2-line"></i>
                        </button>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <template v-for="(valid,i) in valids">
                                <div v-if="valid.data.name == part.part">
                                    <img class="img-fluid" :src="imageLink+'/'+valid.segment+'/'+valid.part"
                                         alt="screeshot">
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-danger mt-4" @click="rem(p)">
                            <i class="ri-close-line"></i>
                        </button>
                    </div>
                </div>

                <div v-if="p == activeIndex">
                    <hr>
                    <div class="p-3">
                        <input type="text" v-model="q" class="form-control" placeholder="search...">
                    </div>
                    <div class="p-3">
                        <ul class="filter">
                            <li @click="setFilter(null)"  :class="filter == null?'active':''">
                                All
                            </li>
                            <li v-for="segment in segments" :key="segment" :class="filter == segment?'active':''" @click="setFilter(segment)">
                                {{segment}}
                            </li>
                        </ul>
                    </div>
                    <div class="rw">
                        <template v-for="(valid,i) in valids">
                          <template v-if="valid.segment == filter || filter == null">
                              <div v-if="valid.part.toLowerCase().indexOf(q.toLowerCase()) != -1"
                                   @click="changePart(p,valid.segment,valid.part)"
                                   :class="``+(valid.data.name == part.part?'selected-part':'can-select')">
                                  <img class="img-fluid mt-2" :src="imageLink+'/'+valid.segment+'/'+valid.part"
                                       alt="screeshot">
                                  {{ valid.part }} [v{{ valid.data.version }}]
                              </div>
                          </template>
                        </template>
                    </div>
                </div>
            </div>
            <input type="hidden" name="parts[]" :value="JSON.stringify(part)" class="form-control">
        </div>
        <div v-if="parts.length < parseInt(area.max)" class="p-2">
            <div class="btn btn-primary w-100" @click="addPart">
                <i class="ri-add-line"></i>
            </div>
        </div>
        <input type="hidden" name="removed" :value="JSON.stringify(removed)" class="form-control">
    </div>
</template>

<script>
export default {
    name: "area-designer",
    components: {},
    data: () => {
        return {
            partsData: [],
            removed: [],
            activeIndex: null,
            q:'',
            filter: null,
        }
    },
    props: {
        valids: {
            default: [],
            type: Array,
        },
        parts: {
            default: [],
            type: Array,
        },
        area: {
            required: true,
            type: Object,
        },
        imageLink: {
            required: true,
        }
    },
    mounted() {
        this.partsData = this.parts;
    },
    computed: {
        segments(){
            let arr = [];
            for( const valid of this.valids) {
                if (arr.indexOf(valid.segment) == -1) {
                    arr.push(valid.segment);
                }
            }

            return arr;
        }
    },
    methods: {
        setFilter(filter = null){
            this.filter = filter;
        },
        changePart(p, segment, part) {
            this.partsData[p].segment = segment;
            this.partsData[p].part = part;
        },
        addPart() {
            this.partsData.push({
                id: null,
                segment: this.valids[0].segment,
                part: this.valids[0].part,
            });
        },
        rem(i) {
            if (!confirm('Are sure to remove?')) {
                return;
            }
            this.removed.push(this.partsData[i].id);
            this.partsData.splice(i, 1);
        },
        shiftArray(index, offset) {
            console.log(index, offset);
            if (index < 0 || index >= this.partsData.length) {
                return "Index out of bounds";
            }

            const removed = this.partsData.splice(index, 1)[0];
            const newIndex = index + offset;

            if (newIndex < 0) {
                this.partsData.unshift(removed);
            } else if (newIndex >= this.partsData.length) {
                this.partsData.push(removed);
            } else {
                this.partsData.splice(newIndex, 0, removed);
            }

        }


    },
}
</script>

<style scoped>
#area-designer .card-header > .btn:first-of-type {
    margin-inline-start: auto !important;
}

.part-body {
    padding: var(--spacing-md);
}

.rw {
    column-count: 3;
    column-gap: var(--spacing-md);
}

.rw div {
    margin-block-end: var(--spacing-md);
}

.rw img {
    border-radius: var(--radius-sm);
}

.selected-part,
.can-select {
    padding: var(--spacing-xs);
    border: 1px solid transparent;
    border-radius: var(--radius-md);
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-medium);
    break-inside: avoid;
}

.selected-part {
    border-color: var(--color-success-text);
    background-color: var(--color-success-subtle);
    color: var(--color-success-text);
}

.can-select {
    color: var(--color-text-muted);
    cursor: pointer;
}

.can-select:hover {
    background-color: var(--color-hover);
    color: var(--color-text);
}

.can-select:focus-visible,
.filter li:focus-visible {
    outline: 2px solid var(--color-focus-ring);
    outline-offset: 2px;
}

.filter {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: var(--spacing-xs);
    margin: 0;
    padding: 0;
    list-style: none;
}

.filter li {
    display: inline-flex;
    align-items: center;
    min-block-size: var(--control-height-xs);
    padding-inline: var(--spacing-sm);
    border: 1px solid var(--color-border-strong);
    border-radius: var(--radius-full);
    color: var(--color-text-muted);
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-medium);
    cursor: pointer;
}

.filter li:hover {
    background-color: var(--color-hover);
    color: var(--color-text);
}

.filter li.active {
    border-color: transparent;
    background-color: var(--color-primary-subtle);
    color: var(--color-primary-text);
}
</style>
