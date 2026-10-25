<template>
    <div id="vue-a1-calendar">
        <div v-if="pDate !== null">

            <div class="cal-grid">
                <div @click="prvMonth">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path
                            d="M10.0859 12.0001L5.29297 16.793L6.70718 18.2072L12.9143 12.0001L6.70718 5.79297L5.29297 7.20718L10.0859 12.0001ZM17.0001 6.00008L17.0001 18.0001H15.0001L15.0001 6.00008L17.0001 6.00008Z"></path>
                    </svg>
                </div>
                <div>
                    {{ pDate.persianMonthNames[cMonth] }}
                </div>
                <div>
                    <input type="number" min="0" v-model="cYear">
                </div>
                <div @click="nxtMonth">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path
                            d="M13.9142 12.0001L18.7071 7.20718L17.2929 5.79297L11.0858 12.0001L17.2929 18.2072L18.7071 16.793L13.9142 12.0001ZM7 18.0001V6.00008H9V18.0001H7Z"></path>
                    </svg>
                </div>
            </div>
            <table id="vue-cal-table">
                <thead>

                <tr>
                    <th @click="selectByWeekDay(0)">
                        {{ __("Saturday") }}
                    </th>
                    <th @click="selectByWeekDay(1)">
                        {{ __("Sunday") }}
                    </th>
                    <th @click="selectByWeekDay(2)">
                        {{ __("Monday") }}
                    </th>
                    <th @click="selectByWeekDay(3)">
                        {{ __("Tuesday") }}
                    </th>
                    <th @click="selectByWeekDay(4)">
                        {{ __("Wednesday") }}
                    </th>
                    <th @click="selectByWeekDay(5)">
                        {{ __("Thursday") }}
                    </th>
                    <th @click="selectByWeekDay(6)">
                        {{ __("Friday") }}
                    </th>
                </tr>
                </thead>
                <tbody>


                <tr v-for="(tr,i) in monthArray">
                    <td v-for="(td,j) in tr" @mouseenter="hover" @click="selecting(td)" :class="getClass(td)" :title="td.date+' '+td.pDate"
                        :data-timpstamp="td.unixTimeStamp">
                        {{ td.text }}
                        <template v-if="texts[fixDate(td.date)] !== undefined">
                            <div class="a1-badge" v-html="texts[fixDate(td.date)]"></div>
                        </template>
                    </td>
                </tr>
                </tbody>
            </table>
            <input type="hidden" :value="JSON.stringify(selected)" :name="inputName">
        </div>
        <!--      <div>-->
        <!--          {{JSON.stringify(selected)}}-->
        <!--      </div>-->
        <div class="text-center mb-2">
            &nbsp;{{ currentDate }}&nbsp;
        </div>
    </div>
</template>

<script>

import persianDate from './libs/persian-date.js';

export default {
    name: "vue-a1-calendar",
    components: {},
    data: () => {
        return {
            currentDate: '',
            pDate: null,
            cMonth: 4, // current month
            cYear: 1402, // current year
            selected: [],
            selectedTimeStamp: [],
            // translate simple
            strings: {
                Monday: 'دوشنبه',
                Tuesday: 'سه‌شنبه',
                Wednesday: 'چهارشنبه',
                Thursday: 'پنجشنبه',
                Friday: 'آدینه',
                Saturday: 'شنبه',
                Sunday: 'یکشنبه'
            }
        }
    },
    props: {
        month: {
            default: 4,
            type: Number,
        },
        year: {
            default: 1370,
            type: Number,
        },
        texts: {
            default: {},
            type: Object,
        },
        onSelect: {
            type: Function,
            default: function () {

            },
        },
        inputName: {
            type: String,
            default: 'vueCalendarValue'
        },
    },
    mounted() {
        // initial values

        this.cYear = this.year;
        this.cMonth = this.month;

        this.pDate = new persianDate();

    }
    ,
    computed: {
        monthStart() {
            return this.pDate.getPersianWeekDay(this.cYear + '/' + this.cMonth + '/1');
        },
        monthArray() {
            let r = [[]];
            let counter = this.monthStart;


            for (let i = 1; i <= this.monthStart; i++) {
                r[0].push({
                    date: '',
                    text: '',
                    unixTimeStamp: '',
                    pDate: '',
                });
            }

            for (let i = 1; i <= this.pDate.pGetLastDayMonth(this.cMonth, this.cYear); i++) {
                counter++;
                r[r.length - 1].push({
                    date: this.pDate.imploiter(this.pDate.persian2Gregorian([this.cYear, this.cMonth,  i]), '-'),
                    text: this.pDate.parseHindi(i),
                    unixTimeStamp: this.pDate.gDate2Timestamp(this.pDate.persian2Gregorian([this.cYear, this.cMonth, i])),
                    pDate: this.pDate.parseHindi(this.cYear + '/' + this.cMonth + '/' + this.pDate.make2number(i)),
                });
                if (counter % 7 === 0) {
                    r.push([]);
                }
            }

            return r;

        }
        ,
    }
    ,
    methods: {
        /**
         * Maybe one day translator
         * @param txt
         * @returns {*}
         * @private
         */
        __(txt) {
            return this.strings[txt];
        }
        ,
        indexSelected(td) {
            return this.selectedTimeStamp.indexOf(td.unixTimeStamp);
        }
        ,
        /**
         * td object toggle select
         * @param td
         */
        selecting(td) {
            if (td.date === '') {
                return false;
            }
            if (this.indexSelected(td) === -1) {
                this.selected.push(td);
                this.selectedTimeStamp.push(td.unixTimeStamp);
                this.onSelect(td);
            } else {
                this.selected.splice(this.indexSelected(td), 1);
                this.selectedTimeStamp.splice(this.indexSelected(td), 1);
            }
        },
        /**
         * calculate class by props of td
         * @param td
         * @returns {string}
         */
        getClass(td) {
            let cls = '';
            if (td.text === '') {
                return '';
            } else {
                cls += ' selectable-td';
            }

            if (this.indexSelected(td) !== -1) {
                cls += ' selected-td';
            }

            return cls;
        }
        ,
        /**
         * Selected dates by day week
         * @param i
         */
        selectByWeekDay(i) {
            for (const tr of this.monthArray) {
                if (tr[i] !== undefined) {
                    this.selecting(tr[i]);
                }
            }
        },
        hover: function (e) {
            this.currentDate = e.target.getAttribute('title');
        },
        nxtMonth() {
            if (this.cMonth === 12) {
                this.cYear++;
                this.cMonth = 1;
            } else {
                this.cMonth++;
            }
        },
        prvMonth() {
            if (this.cMonth === 1) {
                this.cYear--;
                this.cMonth = 12;
            } else {
                this.cMonth--;
            }
        },
        fixDate(d) {
            let t = d.split('-');
            return parseInt(t[0]) + '-' + (parseInt(t[1]) < 10 ? '0' + parseInt(t[1]) : parseInt(t[1])) + '-' + (parseInt(t[2]) < 10 ? '0' + parseInt(t[2]) : parseInt(t[2]));
        },
    }
}
</script>

<style scoped>
#vue-a1-calendar {
    direction: rtl;
    overflow: hidden;
    border: 1px solid var(--color-border);
    border-radius: var(--radius-lg);
    background-color: var(--color-surface);
    color: var(--color-text);
    font-family: var(--font-family-base);
    user-select: none;
}

#vue-a1-calendar > .text-center {
    color: var(--color-text-muted);
    font-size: var(--font-size-sm);
}

.cal-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    margin: var(--spacing-md);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    background-color: var(--color-field);
    color: var(--color-text);
}

.cal-grid div {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: var(--spacing-sm);
    font-size: var(--font-size-lg);
    font-weight: var(--font-weight-semibold);
    text-align: center;
}

.cal-grid svg {
    inline-size: 1.75rem;
    fill: currentcolor;
}

.cal-grid div:first-child,
.cal-grid div:last-child {
    border-radius: var(--radius-md);
    color: var(--color-text-muted);
    cursor: pointer;
}

.cal-grid div:first-child:hover,
.cal-grid div:last-child:hover {
    background-color: var(--color-hover);
    color: var(--color-text);
}

.cal-grid input {
    inline-size: 6rem;
    padding-inline: var(--spacing-2xs);
    border: none;
    border-radius: var(--radius-sm);
    outline: none;
    background: transparent;
    color: var(--color-text);
    font-size: var(--font-size-lg);
    font-weight: var(--font-weight-semibold);
    text-align: center;
}

.cal-grid div:first-child:focus-visible,
.cal-grid div:last-child:focus-visible,
.cal-grid input:focus-visible,
#vue-cal-table th:focus-visible,
#vue-cal-table td:focus-visible {
    outline: 2px solid var(--color-focus-ring);
    outline-offset: 2px;
}

#vue-cal-table {
    inline-size: calc(100% - 2rem);
    margin: 0 auto var(--spacing-md);
    border-collapse: separate;
    border-spacing: var(--spacing-2xs);
    text-align: center;
}

#vue-cal-table th {
    inline-size: calc(100% / 7);
    padding: var(--spacing-xs);
    border-radius: var(--radius-md);
    color: var(--color-text-muted);
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-semibold);
    cursor: pointer;
}

#vue-cal-table th:hover {
    background-color: var(--color-hover);
    color: var(--color-text);
}

#vue-cal-table td {
    position: relative;
    block-size: 4rem;
    padding: var(--spacing-xs);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    font-size: var(--font-size-lg);
    font-variant-numeric: tabular-nums;
    transition: background-color var(--duration-base) var(--easing-standard), color var(--duration-base) var(--easing-standard), border-color var(--duration-base) var(--easing-standard);
}

#vue-cal-table td:not(.selectable-td) {
    border-color: transparent;
}

#vue-cal-table td.selectable-td {
    background-color: var(--color-field);
    cursor: pointer;
}

#vue-cal-table td.selectable-td:hover {
    background-color: var(--color-hover);
}

#vue-cal-table td.selected-td {
    border-color: var(--color-primary-edge);
    background-color: var(--color-primary);
    color: var(--color-text-on-primary);
}

#vue-cal-table td.selectable-td.selected-td:hover {
    background-color: var(--color-primary-hover);
}

.a1-badge {
    position: absolute;
    inset-block-start: var(--spacing-3xs);
    inset-inline-end: var(--spacing-3xs);
    padding: var(--spacing-3xs) var(--spacing-2xs);
    border-radius: var(--radius-sm);
    background-color: var(--color-accent-subtle);
    color: var(--color-accent-text);
    font-size: var(--font-size-xs);
    line-height: var(--line-height-snug);
    opacity: .85;
    transition: opacity var(--duration-slow) var(--easing-standard);
}

td:hover .a1-badge {
    opacity: 1;
}

@media (prefers-reduced-motion: reduce) {
    #vue-cal-table td,
    .a1-badge {
        transition: none;
    }
}
</style>
