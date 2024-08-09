<template>
    <div id="quantities-add-to-card">
        <template v-for="(q,i) in qz">
            <div :class="`q `+(selected == i?'selected-q':'')" v-if="q.count > 0" @click="select(i)">
                <div class="row">

                    <template v-for="(v,k) in data2object(q.data)">
                        <div :class="calcClass(props[k])">
                            <div v-if="props[k].type == 'color'">
                                <span class="q-color float-start" :style="`background-color:${v}`"></span>
                            </div>
                            <div
                                v-if="props[k].type == 'select' || props[k].type == 'singlemulti' || props[k].type == 'multi'">


                        <span>
                            {{ props[k].label }}:
                        </span>
                                <b>
                                    {{ props[k].data[v] }}
                                </b>
                            </div>
                        </div>
                    </template>
                    <div class="col-md" v-if="discount != null">

                        <strong>
                            {{ calcDiscount(q.price) }}
                        </strong>
                        &nbsp;
                        <del class="text-muted">
                            {{ commafy(q.price.toString()) }} {{ currency }}
                        </del>
                    </div>
                    <div class="col-md" v-else>
                        {{ commafy(q.price.toString()) }} {{ currency }}
                    </div>
                </div>
            </div>
        </template>
        <a
            class="btn btn-outline-primary btn-lg" @click="add2card">
            <i class="ri-shopping-bag-3-line"></i>
            {{ translate['add-to-card'] }}
        </a>
    </div>
</template>

<script>

function commafy(num) {
    if (typeof num !== 'string') {
        return '';
    }
    let str = uncommafy(num.toString()).split('.');
    if (str[0].length >= 4) {
        str[0] = str[0].replace(/(\d)(?=(\d{3})+$)/g, '$1,');
    }
    if (str[1] && str[1].length >= 4) {
        str[1] = str[1].replace(/(\d{3})/g, '$1 ');
    }
    return str.join('.');
}

function uncommafy(txt) {
    return txt.split(',').join('');
}

export default {
    name: "quantities-add-to-card",
    components: {},
    data: () => {
        return {
            selected: null,
        }
    },
    props: {
        qz: {
            default: []
        },
        props: {
            default: {},
        },
        currency: {
            default: '$',
        },
        cardLink: {
            default: '',
        },
        discount: {
            default: null,
        },
        translate: {
            default: {},
        }
    },
    mounted() {

    },
    computed: {},
    methods: {
        select(i) {
            document.querySelector('#price').innerText = commafy(this.qz[i].price.toString()) + ' ' + this.currency;
            let index = this.qz[i].image;
            document.querySelector('#preview a').setAttribute('href', document.querySelector(`#hidden-images a:nth-child(${index + 1})`).getAttribute('href'));
            document.querySelector('#preview img').setAttribute('src', document.querySelector(`#hidden-images a:nth-child(${index + 1}) img`).getAttribute('src'));
            this.selected = i;
        },
        async add2card() {
            if (this.selected == null) {
                window.$toast.warning('You need to select one quantity');
                return;
            }

            let resp = await axios.get(this.cardLink + '?quantity=' + this.qz[this.selected].id);
            if (resp.data.success) {
                window.$toast.success(resp.data.message);
                document.querySelectorAll('.card-count')?.forEach(function (el2) {
                    el2.innerText = resp.data.data.count;
                });
            } else {
                window.$toast.error("Error!");
            }
        },
        calcDiscount(price) {
            if (this.discount == null) {
                return '-';
            }
            if (this.discount.type == 'PERCENT') {
                return commafy(
                    parseInt(((100 - this.discount.amount) * price) / 100).toString()
                ) + ' ' + this.currency;
            } else {
                return commafy((price - this.discount.amount).toString()) + ' ' + this.currency;
            }
        },
        calcClass(prop) {
            let cls = '';
            if (prop.type == 'color') {
                cls = 'col-md-1';
            } else {
                cls = 'col-md';
            }
            cls += ' ' + prop.type;
            return cls;
        },
        data2object(data) {
            try {
                return JSON.parse(data);
            } catch {
                return '';
            }
        },
        commafy: commafy,
    }
}
</script>

<style scoped>
#quantities-add-to-card {

}

.q {
    border: 1px solid var(--xshop-primary);
    border-radius: var(--xshop-border-radius);
    margin-bottom: .5rem;
    align-items: center;
    cursor: pointer;
    transition: 300ms;
    padding: 7px;


    &:hover {
        background: var(--xshop-primary);
        color: var(--xshop-diff);
    }
}

.q-color {
    display: inline-block;
    width: 20px;
    height: 20px;
    border-radius: 50%;
}

.selected-q {
    background: var(--xshop-secondary);
    color: var(--xshop-diff2);
}

</style>
