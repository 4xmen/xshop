<template>
    <div id="tag-input">
        <div class="form-control">
             <span class="tag-select" v-for="$tag in tags">
                    {{$tag}}
                 <i class="ri-close-line" @click="rem($tag)"></i>
             </span>
            <input type="text" v-model="tag" :id="xid"
                   @keyup.enter.prevent="addTag"
                   @focus="disableSubmit"
                   @blur="enableSubmit" :placeholder="xtitle">
            <input :name="xname" type="hidden" :value="tags.join(splitter)">
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
            if (this.tag.trim()) { // Check if the input is not empty
                this.tags.push(this.tag.trim()); // Add the trimmed tag
                this.tag = ''; // Reset the input
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
</style>
