<template>
    <div id="searchable-select" ref="main">
        <div id="ss-modal" @click.self="hideModal" v-if="modalShow">
            <div id="ss-selector">
                <div class="p-2">
                    <input type="text" class="form-control search" v-model="q" :placeholder="xtitle">
                </div>
                <div class="p-2">
                    <ul id="vue-search-list" class="list-group list-group-flush">
                        <template v-for="(item,i) in items">
                            <li
                                tabindex="-1"
                                v-if="finder(item[titleField])"
                                @click="selecting(item[valueField])"
                                :class="`list-group-item ${val.indexOf(item[valueField]) !== -1?'selected':''} ${focsed == i?'focused':''}`">
                                <template v-if="xlang == null">
                                    {{ item[titleField] }}
                                </template>
                                <template v-else>
                                    {{ item[titleField][xlang] }}
                                </template>

                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend" id="vue-search-btn">
                <button class="input-group-text" id="basic-addon1" type="button" @click="showModal">
                    <i class="ri-check-line"></i>
                </button>
            </div>
            <div class="form-control" id="vue-lst" @click.self="showModal">
                <template v-for="item in items">
                    <span class="tag-select" v-if=" val.indexOf(item[valueField]) !== -1">
                        <template v-if="xlang == null">
                                    {{ item[titleField] }}
                        </template>
                        <template v-else>
                            {{ item[titleField][xlang] }}
                        </template>
                        <i class="ri-close-line" @click="rem(item[valueField])"></i>
                    </span>
                </template>

            </div>
        </div>
    </div>
    <input type="hidden" :name="xname" :value="JSON.stringify(val)">
</template>

<script>
export default {
    name: "searchable-select",
    components: {},
    data: () => {
        return {
            modalShow: false, // modal handle
            q: '', // search query
            val: [],
            focsed: -1,
        }
    },
    emits: ['update:modelValue'],
    props: {
        xlang: {
            default: null
        },
        modelValue: {
            default: 'nop',
        },
        items: {
            required: true,
            default: [],
            type: Array,
        },
        valueField: {
            default: 'id',
            type: String,
        },
        titleField: {
            default: 'title',
            type: String,
        },
        xname: {
            default: "",
            type: String,
        },
        xtitle: {
            default: "Please select",
            type: String,
        },
        xvalue: {
            default: [],
            type: Array,
        },
        xid: {
            default: "",
            type: String,
        },
        customClass: {
            default: "",
            type: String,
        },
        err: {
            default: false,
            type: Boolean,
        },

        onSelect: {
            default: function () {

            },
            type: Function,
        },
    },
    mounted() {
        if (this.modelValue != 'nop') {
            this.val = this.modelValue;
        } else {
            this.val = this.xvalue;
        }
    },
    computed: {
        getClass: function () {
            if (this.err == true || (typeof this.err == 'String' && this.err.trim() == '1')) {
                return 'form-control is-invalid ' + this.customClass;
            }
            return 'form-control ' + this.customClass;
        },
    },
    methods: {
        finder(term = '') {
            //(q != '' && item[titleField].indexOf(q) != -1) || (q == '')
            if (this.q == '' || term == '') {
                return true;
            }
            if (typeof term == 'string' && term.toLocaleLowerCase().indexOf(this.q.toLocaleLowerCase()) != -1) {
                return true
            } else if (typeof term == 'object') {
                try {
                    for (const t in term) {
                        if (term[t].toLowerCase().indexOf(this.q.toLocaleLowerCase()) != -1) {
                            return true;
                        }
                    }
                } catch (e) {

                    console.log(e.message);
                }
            } else {
                return true;
            }
            return false;
        },
        rem(i) {
            this.val.splice(this.val.indexOf(i), 1);
            this.onSelect(this.val, i);
        },
        selecting(i) {
            if (this.val.indexOf(i) == -1) {
                this.val.push(i);
            } else {
                this.val.splice(this.val.indexOf(i), 1);
            }
            this.onSelect(this.val, i);
        },
        select() {
            this.onSelect(this.val);
        },
        hideModal: function () {
            this.modalShow = false;
            document.removeEventListener('keydown', this.keyHandle);
        },
        showModal() {
            this.modalShow = true;
            setTimeout(() => {
                if (this.$refs.main.querySelector('.search') != null) {
                    this.$refs.main.querySelector('.search').focus();
                }
            }, 100);
            // this.$refs.main.querySelector('.search').focus();
            document.addEventListener('keydown', this.keyHandle);
        },
        keyHandle(e) {
            if (e.key == 'Escape') {
                this.hideModal();
            }
            try {
                if (this.$refs.main.querySelector('.search') == document.activeElement) {
                    if (e.code == 'Tab') {
                        e.preventDefault();
                        this.$refs.main.querySelector('.search').blur();
                        this.focsed = 0;
                    }
                    return;
                }
            } catch {
            }

            e.preventDefault();
            if (e.key == 'ArrowDown') {
                this.focsed++;
                if (this.focsed > this.items.length - 1) {
                    this.focsed = this.items.length - 1;
                }
            } else if (e.key == 'ArrowUp') {
                this.focsed--;
                if (this.focsed < -1) {
                    this.focsed = -1;
                }
            } else if (e.key == ' ' || e.key == 'Enter') {
                this.selecting(this.items[this.focsed][this.valueField]);
            }
            return false;
            // console.log(e.key);
        }
    },
    watch: {
        val(newValue) {
            if (this.modelValue != 'nop') {
                this.$emit('update:modelValue', newValue);
            }
        }
    }
}
</script>

<style scoped>
#searchable-select {

}

#vue-search-btn {
    cursor: pointer;
    user-select: none;
}

#vue-search-btn:hover .input-group-text {
    background: deepskyblue;
}


#ss-modal {
    position: fixed;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    z-index: 999;
    background: #ffffff33;
    backdrop-filter: blur(4px);
    user-select: none;
}

#ss-selector {
    height: 60vh;
    border-radius: 7px;
    min-width: 350px;
    width: 400px;
    max-width: 90%;
    margin: 20vh auto;
    background: var(--xshop-background);
    box-shadow: 0 0 4px gray;
    padding: 5px;
}

#vue-search-list {
    height: calc(60vh - 90px);
    overflow-x: auto;
}

#vue-search-list .list-group-item:hover, #vue-search-list .list-group-item.focused {
    background: var(--xshop-primary);
}

#vue-search-list .list-group-item.selected {
    background: var(--xshop-secondary);
    color: white;;
}

#vue-search-list .list-group-item.selected:hover, #vue-search-list .list-group-item.selected.focused {
    background: var(--xshop-primary) !important;
}

#vue-lst {
    user-select: none;
    white-space: nowrap;
    overflow: hidden;
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
