<template>
    <div id="card">
        <ul class="steps">
            <li class="active">
                <div class="circle" @click="changeIndex(0)">
                    <i class="ri-vip-diamond-line"></i>
                </div>
                {{ translate['shopping-card'] }}
            </li>
            <li :class="index > 0 ?'active':''">
                <div class="circle" @click="changeIndex(1)">
                    <i class="ri-truck-line"></i>
                </div>

                {{ translate['transport'] }}
            </li>
            <li :class="index > 1 ?'active':''">
                <div class="circle" @click="changeIndex(2)">
                    <i class="ri-bank-card-2-line"></i>
                </div>
                {{ translate['discount-pay'] }}
            </li>
        </ul>
        <div class="row">
            <div class="col-lg-3">
                <aside>
                    <h6 class="text-center">
                        {{ translate['total-price'] }}:
                    </h6>
                    <h2 class="text-center" v-if="index == 0">
                        {{ priceing(total) }}
                    </h2>
                    <h2 class="text-center" v-if="index == 1">
                        {{ priceing(totalWithTransport) }}
                    </h2>
                    <h2 class="text-center" v-if="index == 2">
                        {{ priceing(totalWithTransportDiscount) }}
                    </h2>

                    <hr>
                    <i class="ri-user-line icon"></i>
                    <slot></slot>
                </aside>
            </div>
            <div class="col-lg-9">
                <div :class="'tab' + (index == 0?'':' hide')">
                    <table class="table">
                        <thead>

                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                {{ translate['image'] }}
                            </th>
                            <th>
                                {{ translate['name'] }}
                            </th>
                            <th class="text-center" style="width: 400px">
                                {{ translate['quantity'] }}
                            </th>
                            <th>
                                {{ translate['price'] }}
                            </th>
                            <th>
                                {{ translate['count'] }}
                            </th>
                            <th>
                                -
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="(item,i) in items">
                            <td>
                                <input type="hidden" :name="`product_id[${i}]`" :value="item.id">
                                {{ i + 1 }}
                            </td>
                            <td>
                                <img :src="item.image" :alt="item.name">
                            </td>
                            <td>
                                <a :href="this.productLink + item.slug">
                                    {{ item.name }}
                                </a>
                            </td>
                            <td class="text-center">
                                <template v-if="item.qz.length != 0">
                                    <template v-if="qz[i] == null">
                                        <q-index :i="i" :qz="item.qz" :base-price="item.price"
                                                 :symbol="symbol"
                                                 :on-change="changeQ" :xname="`quantity_id[${i}]`"></q-index>
                                    </template>
                                    <template v-else>
                                        <input type="hidden" :name="`quantity_id[${i}]`" :value="item.q.id">
                                        <q-preview :q="item.q"></q-preview>
                                    </template>
                                </template>
                                <span v-else>
                                    -
                                    <input type="hidden" :name="`quantity_id[${i}]`">
                                </span>
                            </td>
                            <th>
                                {{ priceing(pricez[i]) }}
                            </th>
                            <td>
                                <quantity :max="maxz[i]" :xname="`count[${i}]`" v-model="countz[i]"></quantity>
                            </td>
                            <td>
                                <a type="button" class="btn btn-danger btn-sm text-light"
                                   :href="this.cardLink + item.slug">
                                    <i class="ri-close-line"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="4">
                                {{ translate['total-price'] }}
                            </th>
                            <th colspan="4">
                                {{ priceing(total) }}
                            </th>
                        </tr>
                        </tfoot>

                    </table>
                </div>
                <div :class="'tab' + (index == 1?'':' hide')">
                    <div>
                        <h5>
                            {{ translate['sent-to'] }}:
                        </h5>
                        <div v-for="(adr,j) in addresses" class="addr">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" :value="adr.id" :checked="j == 0"
                                       name="address_id" :id="'adr'+j">
                                <label class="form-check-label" :for="'adr'+j">
                                    {{ adr.address }}
                                </label>
                            </div>
                        </div>
                        <div v-if="transports.length > 0">
                            <h5 class="mt-3">
                                {{ translate['transport'] }}::
                            </h5>
                            <div v-for="(trs,j) in transports" class="addr">
                                <span class="float-end p-2 badge bg-primary m-2">
                                    {{ priceing(trs.price) }}
                                </span>

                                <i :class="'float-start '+trs.icon"></i>
                                <div class="form-check">

                                    <input class="form-check-input" :value="trs.id" type="radio"
                                           v-model="transport_index" name="transport_id" :id="'t'+j">
                                    <label class="form-check-label" :for="'t'+j">
                                        {{ trs.title }}
                                    </label>
                                    <p>
                                        {{ trs.description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div :class="'tab' + (index == 2?'':' hide')">

                    <!-- WIP translate & discount check  -->
                    <h5 class="mt-1">
                        {{ translate['check-dis'] }}:
                    </h5>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="ri-percent-line"></i></span>
                        <input type="text" class="form-control text-center" placeholder="Discount code"
                               :readonly="discount != null" v-model="code">
                        <button type="button" class="input-group-text btn btn-primary" @click="discountCheck">
                            {{ translate['check'] }}
                        </button>
                    </div>
                    <div v-if="discount_id != null">
                        <input type="hidden" name="discount_id" :value="discount_id">
                        <div class="alert alert-success">
                            {{ discount_human }}
                        </div>
                    </div>

                    <h4>
                        {{ translate['extra-desc'] }}
                    </h4>
                    <textarea rows="4" class="form-control" name="desc" :placeholder="translate['your-msg']"></textarea>
                    <hr>
                    <button v-if="canPay" class="btn btn-outline-primary w-100 btn-lg">
                        <i class="ri-bank-card-2-line"></i>
                        {{ translate['pay-now'] }}
                    </button>
                    <div v-else class="alert alert-danger">
                        {{ translate['plz'] }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import QIndex from "./Qindex.vue";
import QPreview from "./Qpreview.vue";
import quantity from "./Quantity.vue";

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
    name: "card",
    components: {quantity, QPreview, QIndex},
    data: () => {
        return {
            countz: [], // counts
            qz: [], // qunatities
            itemz: [], // card items
            pricez: [], // price
            maxz: [],
            index: 0,
            transport_index: null,
            code: '',
            discount_id: null,
            discount_human: '',
            discount: null,
        }
    },
    props: {
        productLink: {
            required: true,
        },
        cardLink: {
            required: true,
        },
        discountLink: {
            required: true,
        },
        items: {
            default: [],
        },
        qs: {
            default: [],
        },
        symbol: {
            default: '$',
        },
        addresses: {
            default: []
        },
        transports: {
            default: [],
        },
        canPay: {
            type: Boolean,
            default: false,
        },
        defTransport: {
            default: null,
        },
        translate: {
            default: {},
        }
    },
    mounted() {
        this.qz = this.qs;
        this.transport_index = this.defTransport;
        for (const item of this.items) {
            this.countz.push(1);
            this.pricez.push(item.price);
            this.itemz.push(item);
            this.maxz.push(item.max);
        }

        // fixed price by quantity
        for (const i in this.itemz) {
            if (this.qz[i] != null) {
                for (const q of this.itemz[i].qz) {
                    if (q.id == this.qz[i]) {
                        this.pricez[i] = q.price;
                        // fixed max for selected quantity
                        this.maxz[i] = q.count;
                        try {
                            this.itemz[i].q = q;
                        } catch (e) {
                            this.itemz[i].q = {};
                        }

                    }
                }

            }
        }


    },
    computed: {
        total() {
            let sum = 0;
            for (const i in this.pricez) {
                sum += this.pricez[i] * this.countz[i];
            }

            return sum;
        },
        totalWithTransport() {
            let sum = 0;
            for (const i in this.pricez) {
                sum += this.pricez[i] * this.countz[i];
            }

            let t = 0;
            for (const trs of this.transports) {
                if (trs.id == this.transport_index) {
                    t = trs.price;
                    break;
                }
            }

            return sum + t;
        },
        totalWithTransportDiscount() {
            let sum = 0;
            for (const i in this.pricez) {
                sum += this.pricez[i] * this.countz[i];
            }

            let t = 0;
            for (const trs of this.transports) {
                if (trs.id == this.transport_index) {
                    t = trs.price;
                    break;
                }
            }


            if (this.discount != null) {
                if (this.discount.type == 'PERCENT') {
                    sum = ((100 - this.discount.amount) * sum) / 100;
                } else {
                    sum -= this.discount.amount;
                }
            }
            return sum + t;
        }
    },
    methods: {
        async discountCheck() {
            const url = this.discountLink + this.code;
            try {

                let resp = await axios.get(url);

                if (!resp.data.OK) {
                    window.$toast.error(resp.data.err);
                } else {
                    window.$toast.success(resp.data.msg);
                    this.discount_id = resp.data.data.id;
                    this.discount_human = resp.data.human;
                    this.discount = resp.data.data;
                }
            } catch (e) {
                window.$toast.error(e.message);
            }


        },
        changeIndex(i) {
            this.index = i;
            this.$forceUpdate();
        },
        changeQ(i, q) {
            // console.log(i,q,'iq');
            this.maxz[i] = q.count;
            this.pricez[i] = q.price;
            if (this.maxz[i] < this.countz[i]) {
                this.countz[i] = this.maxz[i];
            }
        },
        priceing(p) {
            if (p == null || p == undefined) {
                return '';
            }
            return commafy(p.toString()) + ' ' + this.symbol;
        }
    },
}
</script>

<style scoped>

#card {

    table {
        margin-bottom: 5px;
    }

    img {
        height: 64px;
        width: 64px;
        object-fit: cover;
        border-radius: var(--xshop-border-radius);
    }

    table td, table th {
        padding: 1rem;
        vertical-align: middle;

        &:first-child, &:last-child {
            text-align: center;
        }

        &:nth-child(2) {
            text-align: center;
            width: 75px;
        }
    }
}

.steps {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    list-style: none;

    li {
        position: relative;
        text-align: center;

        .circle {
            transition: 500ms;
            border-radius: 50%;
            border: 2px solid var(--xshop-secondary);
            width: 82px;
            height: 82px;
            text-align: center;
            margin: 0 auto 1rem;
            background: var(--xshop-secondary);
            position: relative;
            z-index: 2;
            cursor: pointer;
        }

        i {
            font-size: 55px;
            color: var(--xshop-diff2);
            -webkit-text-stroke: 2px var(--xshop-secondary);
            transition: 500ms;
        }

        &:before {
            content: ' ';
            top: 35%;
            inset-inline-start: 0;
            height: 1px;
            background: var(--xshop-secondary);
            position: absolute;
            width: 100%;
        }

        &:after {
            content: ' ';
            top: 35%;
            inset-inline-start: 0;
            height: 1px;
            background: var(--xshop-primary);
            position: absolute;
            width: 0;
            transition: 500ms;
        }

        &.active {
            color: var(--xshop-primary);

            .circle {
                background: var(--xshop-primary);
                color: var(--xshop-diff);
                border-color: var(--xshop-primary);

                i {
                    -webkit-text-stroke: 2px var(--xshop-primary);
                }
            }

            &:after {
                width: 100%;
            }
        }

    }
}

aside {
    background: var(--xshop-primary);
    color: var(--xshop-diff2);
    border-radius: var(--xshop-border-radius);
    padding: 1rem;
    min-height: 98%;
    text-align: center;

    .icon {
        font-size: 64px;
    }
}

.addr {
    border-radius: var(--xshop-border-radius);
    border: var(--xshop-primary) 1px solid;
    margin-bottom: 7px;

    label {
        padding: 1rem;
        display: block;
    }

    input {
        margin: 1rem;
    }

    i {
        font-size: 45px;
        color: var(--xshop-secondary);
        margin: 1rem;
    }
}

.hide {
    max-height: 0 !important;
    overflow: hidden;
}

.tab {
    max-height: 3000px;
    overflow-y: auto;
    transition: 300ms;
}
</style>
