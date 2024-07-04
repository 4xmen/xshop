<template>
    <div id="area-designer">
        <div class="card mt-2" v-for="(part,p) in partsData">
            <div class="card-header">
                Part {{p+1}}
            </div>
            <div class="part-body">
                <div class="row">
                    <template v-for="(valid,i) in valids">
                    <div @click="changePart(p,valid.segment,valid.part)" :class="`col-md-3 `+(valid.data.name == part.part?'selected-part':'can-select')" >
                        <img class="img-fluid mt-2" :src="imageLink+'/'+valid.segment+'/'+valid.part" alt="screeshot">
                        {{valid.part}} [v{{valid.data.version}}]
                    </div>
                    </template>
                </div>
                <input type="hidden" name="parts[]" :value="JSON.stringify(part)" class="form-control">
            </div>
        </div>
        <div v-if="parts.length < parseInt(area.max)" class="p-2">
            <div class="btn btn-primary w-100" @click="addPart">
                <i class="ri-add-line"></i>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "area-designer",
    components: {},
    data: () => {
        return {
            partsData:[],
        }
    },
    props: {
        valids:{
            default:[],
            type: Array,
        },
        parts:{
            default:[],
            type: Array,
        },
        area:{
            required: true,
            type: Object,
        },
        imageLink:{
            required: true,
        }
    },
    mounted() {
        this.partsData = this.parts;
    },
    computed: {},
    methods: {
        changePart(p,segment,part){
            this.partsData[p].segment = segment;
            this.partsData[p].part = part;
        },
        addPart(){
            this.partsData.push({
                id: null,
                segment: this.valids[0].segment,
                part: this.valids[0].part,
            });
        }
    }
}
</script>

<style scoped>
#area-designer {

}
.selected-part{
    background: #32CD3233;
}
.can-select{
    cursor: pointer;
}
</style>
