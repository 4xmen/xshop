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
        allowNew:{
            default: true,
            type: Boolean,
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
        },
        maxCount:{
            default: -1,
            type: Number,
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
            if (this.maxCount !== -1 && this.tags.length >= this.maxCount){
                $toast.warning(`Max value count is : ${this.maxCount}`);
                return false;
            }
            if (this.selectedIndex > -1 && (this.selectedIndex + 1) < this.searchList.length ){
                this.tags.push(this.searchList[this.selectedIndex]) ;
                this.tag = '';
                this.searchList = [];
                this.checkDuplicate();
                this.$emit('update:modelValue', this.tags.join(this.splitter));
                return;
            }
            if (this.tag.trim() && this.allowNew) { // Check if the input is not empty
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
            if (this.maxCount !== -1 && this.tags.length >= this.maxCount){
                $toast.warning(`Max value count is : ${this.maxCount}`);
                return false;
            }
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
    padding-block: var(--spacing-xs);
}

#tag-input > .form-control {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: var(--spacing-2xs);
    min-block-size: var(--control-height-sm);
    padding-block: var(--spacing-2xs);
    cursor: text;
}

#tag-input > .form-control:focus-within {
    border-color: var(--color-focus-ring);
    box-shadow: 0 0 0 1px var(--color-focus-ring);
}

#tag-input input {
    flex: 1 1 8rem;
    min-inline-size: 0;
    min-block-size: calc(var(--control-height-sm) - var(--spacing-xs) - 2px);
    padding: 0;
    border: 0;
    outline: none;
    background: transparent;
    color: var(--color-text);
    font-size: var(--font-size-sm);
}

#tag-input input::placeholder {
    color: var(--color-text-disabled);
}

.tag-select {
    display: inline-flex;
    flex: none;
    align-items: center;
    gap: var(--spacing-3xs);
    block-size: 1.5rem;
    padding-inline: var(--spacing-xs) var(--spacing-3xs);
    border-radius: var(--radius-full);
    background-color: var(--color-primary-subtle);
    color: var(--color-primary-text);
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-medium);
    line-height: 1;
}

.tag-select i {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    inline-size: 1.125rem;
    block-size: 1.125rem;
    border-radius: var(--radius-full);
    font-size: var(--font-size-sm);
    cursor: pointer;
}

.tag-select i:hover {
    background-color: var(--color-primary);
    color: var(--color-text-on-primary);
}

.tag-select i:focus-visible {
    outline: 2px solid var(--color-focus-ring);
    outline-offset: 2px;
}

#search-list {
    flex-basis: 100%;
    margin: 0;
    padding: var(--spacing-2xs);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    background-color: var(--color-surface-raised);
    box-shadow: var(--shadow-md);
    list-style: none;
}

#search-list li {
    display: flex;
    align-items: center;
    min-block-size: var(--control-height-xs);
    padding-block: var(--spacing-2xs);
    padding-inline: var(--spacing-2xs) var(--spacing-sm);
    border-radius: var(--radius-sm);
    color: var(--color-text);
    font-size: var(--font-size-sm);
    cursor: pointer;
}

#search-list li i {
    color: var(--color-text-muted);
}

#search-list li:hover {
    background-color: var(--color-hover);
}

#search-list li.selected {
    background-color: var(--color-primary-subtle);
    color: var(--color-primary-text);
    font-weight: var(--font-weight-medium);
}

#search-list li.selected i {
    color: inherit;
}

#search-list li:focus-visible {
    outline: 2px solid var(--color-focus-ring);
    outline-offset: 2px;
}
</style>
