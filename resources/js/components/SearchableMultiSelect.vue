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
                                    {{ item[titleField]?.[xlang] ?? item[titleField] }}
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
                            {{ item[titleField]?.[xlang] ?? item[titleField] }}
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
#vue-search-btn {
    display: flex;
    user-select: none;
}

#vue-search-btn .input-group-text {
    min-block-size: var(--control-height-sm);
    border-color: var(--color-border-strong);
    border-start-end-radius: 0;
    border-end-end-radius: 0;
    background-color: var(--color-surface-raised);
    color: var(--color-text-muted);
    font-size: var(--font-size-md);
    cursor: pointer;
}

#vue-search-btn .input-group-text:hover {
    background-color: var(--color-hover);
    color: var(--color-text);
}

#vue-search-btn .input-group-text:focus-visible {
    position: relative;
    z-index: 5;
    outline: 2px solid var(--color-focus-ring);
    outline-offset: 2px;
}

#ss-modal {
    position: fixed;
    inset: 0;
    z-index: var(--z-index-overlay);
    background-color: var(--color-overlay);
    backdrop-filter: blur(4px);
    user-select: none;
}

#ss-selector {
    block-size: 60vh;
    min-inline-size: 350px;
    inline-size: 400px;
    max-inline-size: 90%;
    margin: 20vh auto;
    padding: var(--spacing-2xs);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    background-color: var(--color-surface-raised);
    color: var(--color-text);
    box-shadow: var(--shadow-md);
}

#vue-search-list {
    gap: var(--spacing-3xs);
    block-size: calc(60vh - 90px);
    overflow-y: auto;
}

#vue-search-list .list-group-item {
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

#vue-search-list .list-group-item:hover,
#vue-search-list .list-group-item.focused {
    background-color: var(--color-hover);
}

#vue-search-list .list-group-item.focused {
    box-shadow: inset 0 0 0 1px var(--color-border-strong);
}

#vue-search-list .list-group-item.selected {
    background-color: var(--color-primary-subtle);
    color: var(--color-primary-text);
    font-weight: var(--font-weight-medium);
}

#vue-search-list .list-group-item.selected.focused {
    box-shadow: inset 0 0 0 1px var(--color-primary-text);
}

#vue-search-list .list-group-item:focus-visible {
    outline: 2px solid var(--color-focus-ring);
    outline-offset: 2px;
}

#vue-lst {
    display: flex;
    align-items: center;
    gap: var(--spacing-2xs);
    min-block-size: var(--control-height-sm);
    padding-block: var(--spacing-2xs);
    overflow: hidden;
    white-space: nowrap;
    cursor: pointer;
    user-select: none;
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
</style>
