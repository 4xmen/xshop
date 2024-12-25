<template>
    <div id="tag-input">
        <div class="form-control">
             <span class="tag-select" v-for="$tag in tags">
                    {{$tag}}
                 <i class="ri-close-line" @click="rem($tag)"></i>
             </span>
            <input type="text" v-model="tag" :id="xid"
                   @keyup.enter.prevent="addTag"
                   @keyup="checkAutoComplete"
                   @keyup.down.prevent="incIndex"
                   @keyup.up.prevent="decIndex"
                   @focus="disableSubmit"
                   @blur="enableSubmit" :placeholder="xtitle">
            <input :name="xname" type="hidden" :value="tags.join(splitter)">
            <ul id="search-list" v-if="searchList.length > 0">
                <li v-for="(word,i) in searchList" @click="selectTag(i)" :class="selectedIndex == i?'selected':''">
                    <i class="ri-price-tag-3-line float-start mx-2" ></i>
                    {{word}}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>

const noSubmit = function (e) {
  e.preventDefault();
};
export default {
    name: "tag-input",
    components: {},
    data: () => {
        return {
            tag: '',
            tags: [],
            searchList:[],
            selectedIndex: -1,
        }
    },
    emits: ['update:modelValue'],
    props: {
        xid:{
          default: 'tags',
        },
        modelValue: {
            default: null,
        },
        xname:{
            default: '',
            type: String,
        },
        xtitle:{
            default: 'tags',
            type: String,
        },
        splitter:{
            default: ',',
            type: String,
        },
        xvalue:{
            default: '',
            type: String,
        },
        onSelect: {
            default: function () {

            },
            type: Function,
        },
        autoComplete:{
            default: '',
            type: String,
        }
    },
    mounted() {
        if (this.modelValue != null) {
            this.tags = this.modelValue.split(this.splitter);
        }else{
            this.tags = this.xvalue.split(this.splitter);
        }
        this.tags = this.tags.filter(function (el) {
            return el != null && el != '';
        });
    },
    computed: {},
    methods: {
        addTag(e) {
            if (this.selectedIndex > -1 && (this.selectedIndex + 1) < this.searchList.length ){
                this.tags.push(this.searchList[this.selectedIndex]) ;
                this.tag = '';
                this.searchList = [];
                this.checkDuplicate();
                this.$emit('update:modelValue', this.tags.join(this.splitter));
                return;
            }
            if (this.tag.trim()) { // Check if the input is not empty
                this.tags.push(this.tag.trim()); // Add the trimmed tag
                this.tag = ''; // Reset the input
                this.checkDuplicate();
                this.$emit('update:modelValue', this.tags.join(this.splitter));
            }
        },
        disableSubmit(e){
            e.target.closest('form').addEventListener('submit',noSubmit);
            window.noSubmit = true;
        },
        enableSubmit(e){
            e.target.closest('form').removeEventListener('submit',noSubmit);
            window.noSubmit = false;
        },
        rem(tag){
            this.tags.splice(this.tags.indexOf(tag),1);
            this.$emit('update:modelValue', this.tags.join(this.splitter));
        },
        async checkAutoComplete(e){

            if (this.autoComplete !== '' && this.tag.length > 2){
              let resp = await axios.get(this.autoComplete + this.tag);
                if (resp.data.OK == true){
                    this.searchList = resp.data.data;
                }
            }

        },
        selectTag(i,e){
            this.tags.push(this.searchList[i]) ;
            this.tag = '';
            this.searchList = [];
            this.checkDuplicate();
            this.$emit('update:modelValue', this.tags.join(this.splitter));
        },
        incIndex(){
            this.selectedIndex++;
        },
        decIndex(){
            this.selectedIndex--;
        },
        checkDuplicate(){
            this.tags = [...new Set(this.tags)];
        }
    }
}
</script>

<style scoped>
#tag-input {
    padding: .5rem 0;
}

#tag-input input{
    background: transparent;
    border: 0;
    outline: none;
}


.tag-select {
    display: inline-block;
    padding: 0 4px 0 20px;
    margin-right: 5px;
    background: #282c34dd;
    color: white;
    position: relative;
    border-radius: 3px;
}

.tag-select i {
    font-size: 20px;
    position: absolute;
    left: 0;
    top: -5px;
}

.tag-select i:hover {
    color: red;
}

#search-list{
    padding: 0;
    list-style: none;
    li{
        border-bottom: 1px solid silver;
        padding: 4px;

        &:last-child{
            border-bottom: 0;
        }

        &.selected{
            background: olive;
        }
    }
    border: 1px solid grey;
    border-radius: 6px;
}
</style>
