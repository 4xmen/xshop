<template>
    <div id="area-designer">
        <div class="card mt-2" v-for="(part,p) in partsData">
            <div class="card-header">
                Part {{ p + 1 }}
                <span v-if="p !== 0" class="btn btn-secondary btn-sm float-end mx-1" @click="shiftArray(p,-1)">
                    <i class="ri-arrow-up-line"></i>
                </span>
                <span v-if="p != partsData.length - 1" class="btn btn-secondary btn-sm float-end mx-1" @click="shiftArray(p,1)">
                    <i class="ri-arrow-down-line"></i>
                </span>
            </div>
            <div class="part-body">
                <div class="row">
                    <template v-for="(valid,i) in valids">
                        <div @click="changePart(p,valid.segment,valid.part)"
                             :class="`col-md-3 `+(valid.data.name == part.part?'selected-part':'can-select')">
                            <img class="img-fluid mt-2" :src="imageLink+'/'+valid.segment+'/'+valid.part"
                                 alt="screeshot">
                            {{ valid.part }} [v{{ valid.data.version }}]
                        </div>
                    </template>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-danger" @click="rem(p)">
                    <i class="ri-close-line"></i>
                </button>
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
    computed: {},
    methods: {
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
            console.log(index,offset);
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
#area-designer {

}

.selected-part {
    background: #32CD3233;
}

.can-select {
    cursor: pointer;
}
</style>
