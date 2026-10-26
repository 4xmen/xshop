<template>
    <div id="vue-datepicker">

        <div id="dp-modal" @click.self="hideModal" @mousedown.self="canCloseModal = true" v-if="modalShow">
            <div id="picker">
                <div class="equal-width" id="vuejs-tabs">
                    <div :class="tabIndex == 0?'active-tab':''" @click="tabIndex = 0;">
                        {{ pTitle }}
                    </div>
                    <div :class="tabIndex == 1?'active-tab':''" @click="tabIndex = 1;">
                        {{ gTitle }}
                    </div>
                </div>
                <div class="equal-width" v-if="pDate !== null && tabIndex < 2">
                    <div @click="next" class="vuejsbtn">
                        <i class="ri-arrow-left-s-line"></i>
                    </div>
                    <div @click="monthPick">
                        <span v-if="tabIndex == 0">
                            {{ pMonths[parseInt(peDate[1]) - 1] }}
                        </span>
                        <span v-if="tabIndex == 1">
                            {{ gMonths[geDate[1]] }}
                        </span>
                    </div>
                    <div @click="yearPick">
                        <span v-if="tabIndex == 0">
                            {{ pDate.parseHindi(peDate[0]) }}
                        </span>
                        <span v-if="tabIndex == 1">
                            {{ geDate[0] }}
                        </span>
                    </div>
                    <div @click="previous" class="vuejsbtn">
                        <i class="ri-arrow-right-s-line"></i>
                    </div>
                </div>
                <div style="overflow: hidden"
                     @mousedown="startSwipe($event)"
                     @touchstart="startSwipe($event, $event.touches[0])"
                     @mousemove="handleSwipe($event)"
                     @touchmove="handleSwipe($event, $event.touches[0])"
                     @mouseup="endSwipe($event)"
                     @touchend="endSwipe($event)"
                     @mouseleave="endSwipe($event)"
                >
                    <div id="calendar-container" :style="`top:${calContainerTop}px;left:${calContainerLeft}px;`">
                        <div class="sub-picker" v-if="yPicker" dir="rtl">
                            <div class="equal-width month-list" v-for="j in 5">
                                <template v-for="i in 5">
                                    <template v-if="i == 1 && j == 1">
                                        <div @click="startYear -= 23">
                                            <i class="ri-arrow-right-s-line"></i>
                                        </div>
                                    </template>
                                    <template v-else-if="i == 5 && j == 5">
                                        <div @click="startYear += 23">
                                            <i class="ri-arrow-left-s-line"></i>
                                        </div>
                                    </template>
                                    <div v-else class="year"
                                         @click="yearPicking( (startYear - 13) + ( i + ((j - 1)*5)) )">
                                        <span v-if="tabIndex == 0">
                                            {{ pDate.parseHindi((startYear - 13) + (i + ((j - 1) * 5))) }}
                                        </span>
                                        <span v-else>
                                            {{ (startYear - 13) + (i + ((j - 1) * 5)) }}
                                        </span>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="sub-picker" v-if="pmPicker" dir="rtl">
                            <div class="equal-width month-list" v-for="(ms,j) in chunkArray(pMonths,3)">
                                <div v-for="(m,i) in ms" class="month" @click="pMonthPicking((i + (j * 3)))">
                                    {{ m }}
                                </div>
                            </div>
                        </div>
                        <div class="sub-picker" v-if="gmPicker">
                            <div class="equal-width month-list" v-for="(ms,j) in chunkArray(gMonths,3)">
                                <div v-for="(m,i) in ms" class="month" @click="gMonthPicking((i + (j * 3)))">
                                    {{ m }}
                                </div>
                            </div>
                        </div>
                        <div v-if="tabIndex == 0 || _debug" dir="rtl">
                            <table>
                                <thead>
                                <tr>
                                    <th v-for="day in pWeekDays">
                                        {{ day }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody v-if="pDate !== null">
                                <tr v-for="week in pArray">
                                    <td v-for="d in week"
                                        :class="d.class +' '+ isActive(d)"
                                        :title="d.date"
                                        @click="select(d)"
                                        @mouseenter="onMouseEnter(d)"
                                        @mouseleave="onMouseLeave"
                                    >
                                        {{ pDate.parseHindi(d.pDay) }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-if="tabIndex == 1 || _debug">
                            <table>
                                <thead>
                                <tr>
                                    <th v-for="day in gWeekDays">
                                        {{ day }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody v-if="pDate !== null">
                                <tr v-for="week in gArray">
                                    <td v-for="d in week"
                                        :class="d.class +' '+ isActive(d) "
                                        :title="d.pdate"
                                        @click="select(d)"
                                        @mouseenter="onMouseEnter(d)"
                                        @mouseleave="onMouseLeave"
                                    >
                                        {{ d.day }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-if="tabIndex == 2">
                            <div style="padding-top: 10px">

                                <div id="clock"
                                     @mousedown="startDrag"
                                     @mousemove="pickMinutes"
                                     @mouseup="endDrag"
                                     @touchstart="startDrag"
                                     @touchmove.prevent="pickMinutes"
                                     @touchend="endDrag"
                                >
                                    <div id="modes">
                                        <div :class="`vuejs-btn ${mode == 'AM'?'active-selected':''}`"
                                             @click="changeMode('AM')"
                                             @touchend="changeMode('AM')"
                                        >
                                            AM
                                        </div>
                                        <div :class="`vuejs-btn ${mode == 'PM'?'active-selected':''}`"
                                             @click="changeMode('PM')"
                                             @touchend="changeMode('PM')"
                                        >
                                            PM
                                        </div>
                                    </div>
                                    <div id="time">
                                        {{ pDate.make2number(cTime[0]) }} :
                                        {{ pDate.make2number(cTime[1]) }}
                                    </div>
                                    <div id="clock-container">
                                        <div class="wrapper">
                                            <div id="circle"></div>
                                            <div class="bar-seconds">
                                        <span v-for="i in 60" :key="i" :style="{ '--index': i }">
                                          <i :class="{ 'thick-bar': i % 5 === 0 }"></i>
                                        </span>
                                            </div>
                                            <div class="number-hours">
                                        <span v-for="i in 12" :key="i" :style="{ '--index': i }">
                                          <i>
                                              <b @touchend.self="pickHour(i)" @click="pickHour(i)"
                                                 :class="((cTime[0] % 12) == i?'active-selected':'')">
                                                  {{ i }}
                                              </b>
                                          </i>
                                        </span>
                                            </div>
                                            <div class="hands-box">
                                                <div class="hand minutes"
                                                     :style="`transform: rotate(${cTime[1] * 6}deg)`">
                                                    <i></i></div>
                                                <div class="hand hours"
                                                     :style="`transform: rotate(${cTime[0] * 30 + cTime[1] / 2}deg)`">
                                                    <i></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="bottom-bar">
                    <div>
                        <div class="vuejs-btn" title="Clear" @click="clear">
                            <i class="ri-eraser-line"></i>
                        </div>
                    </div>
                    <div class="centered">
                        <span v-if="startDate || endDate != null">
                            [{{ convertToHuman(startDate) }} - {{ convertToHuman(endDate) }}]
                        </span>
                    </div>
                    <div>
                        <div class="vuejs-btn" title="Now" @click="nowSelect">
                            <i class="ri-time-line"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="datepicker">
            <input @focus="modalShow = true" :id="xid" :placeholder="xtitle" :class="getClass" type="text"
                   :value="convertToHuman(startDate) +' - '+ convertToHuman(endDate)">
            <input type="hidden" :name="xname" :value="vals">
        </div>
    </div>
</template>

<script>

import persianDate from './libs/persian-date.js';

const ONE_DAY = 86400;
const ONE_YEAR = ONE_DAY * 365;

function chunkArray(arr, count) {
    const result = [];

    for (let i = 0; i < arr.length; i += count) {
        result.push(arr.slice(i, i + count));
    }

    return result;
}

export default {
    name: "vue-datetimepicker",
    components: {},
    data: () => {
        return {
            _debug: false, // debug all tabs


            /**
             * range
             */
            startDate: null,
            endDate: null,
            hoverDate: null,

            /**
             * to handling swiping calendar
             */
            startX: 0,
            startY: 0,
            swipeDirection: null,
            swipeDistance: 0,
            tableRect: null,
            calContainerTop: 0,
            calContainerLeft: 0,
            isSwiping: false,
            canCloseModal: false,

            /**
             * to handling dragging clock
             */
            isDragging: false,
            fullData: {}, // full data of this date
            modalShow: false, // modal handle
            pDate: null, // persian date update
            startYear: 1970, // start year for year picking
            tabIndex: 0, // active tab index
            current: null, // current is not selected value just for show calendar
            gmPicker: false,  // handle gr month picker modal
            pmPicker: false,// handle persian month picker modal
            yPicker: false, // handle year picker modal
            // val: null, // selected value
            pWeekDays: ['ش', 'ی', 'د', 'س', 'چ', 'پ', 'آ'],
            gWeekDays: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            pMonths: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
            gMonths: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        }
    },
    emits: ['update:modelValue'],
    props: {
        modelValue: {
            default: 'nop',
        },
        xvalue: {
            default: null,
            type: Number,
        },
        xshow: {
            default: 'pdate', // show value
            type: String,
        },
        onSelect: {
            default: function (date) {

            },
            type: Function,
        },
        pTitle: {
            default: 'Persian',
            type: String,
        },
        gTitle: {
            default: 'Gregorian',
            type: String,
        },
        defTab: {
            default: 0,
            type: Number,
        },
        xname: {
            default: "",
            type: String,
        },
        xtitle: {
            default: "",
            type: String,
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
        timepicker: {
            default: false,
            type: Boolean,
        },
        closeOnSelect: {
            default: false,
            type: Boolean,
        },
        xmax: {
            default: null,
            type: Number,
        },
        xmin: {
            default: null,
            type: Number,
        },
    },
    mounted() {
        this.pDate = new persianDate();
        let dt;
        // check value changed by user or not, then ignore xvalue
        if (this.val == null) {
            dt = new Date(parseInt(this.xvalue) * 1000);


            if (this.modelValue != 'nop') {
                if (this.modelValue == null || this.modelValue == '' || this.modelValue == 'null') {
                    dt = new Date();
                    this.val = null;
                    this.current = Math.floor(new Date() / 1000);
                } else {
                    this.current = new Date(parseInt(this.modelValue));
                    this.val = this.modelValue;
                }
            } else {
                if (this.xvalue == null || this.xvalue == '' || this.xvalue == 'null') {
                    dt = new Date();
                    this.val = null;
                    this.current = Math.floor(new Date() / 1000);
                } else {
                    this.current = new Date(parseInt(this.xvalue));
                    this.val = this.xvalue;
                }
            }

            // tab fix
            this.tabIndex = parseInt(this.defTab);


        } else {
            this.current = this.val;
        }
        this.fullData = this.makeDateObject(dt)

        // if (this.xvalue != this.val){
        //
        // }
    },
    computed: {
        vals() {
            return JSON.stringify([this.startDate, this.endDate]);
        },
        // get input class
        getClass: function () {
            if (this.err == true || (typeof this.err == 'String' && this.err.trim() == '1')) {
                return 'form-control is-invalid ' + this.customClass;
            }
            return 'form-control ' + this.customClass;
        },
        /*
         * make array of this month days [gregorian]
         */
        gArray: function () {
            let result = [];
            const baseDate = this.current * 1000;
            let d = new Date(baseDate);
            const currentMonth = d.getMonth(baseDate);
            // find days of last month end by dayweek
            for (let i = 0; i >= -7; i--) {
                d = new Date(baseDate);
                d.setDate(i);
                result.push(this.makeDateObject(d, 'previous'));
                if (d.getDay() == 0) {
                    break;
                }
            }
            result = result.reverse(); // fix sort
            let nextCount = 0;
            // find days of this month and start of next end by dayweek
            for (let i = 1; i <= 45; i++) {
                d = new Date(baseDate);
                d.setDate(i);
                if (d.getMonth() == currentMonth) {
                    result.push(this.makeDateObject(d));
                } else {
                    if (d.getDay() == 0 && nextCount > 0) {
                        break;
                    }
                    result.push(this.makeDateObject(d, 'next'));
                    nextCount++;
                }
            }
            return chunkArray(result, 7);
        },
        /*
         * make array of this month days [persian]
         */
        pArray: function () {
            let result = [];
            const baseDate = this.current * 1000;
            let d = this.pDate.convertDate2Persian(new Date(baseDate));
            const currentMonth = d[1];
            // get current date to prev until last month end by day week
            for (let i = 0; i > -40; i--) {
                let dt = new Date(baseDate + (i * ONE_DAY * 1000));
                let pdt = this.pDate.convertDate2Persian(dt);
                if (pdt[1] == currentMonth) {
                    result.push(this.makeDateObject(dt));
                } else {
                    result.push(this.makeDateObject(dt, 'previous'));
                    if (this.makePWeek(dt) == 0) {
                        break;
                    }
                }
            }
            // fix sort
            result = result.reverse();
            // get current date to next until next month end by day week
            for (let i = 1; i < 40; i++) {
                let dt = new Date(baseDate + (i * ONE_DAY * 1000));
                let pdt = this.pDate.convertDate2Persian(dt);
                if (pdt[1] == currentMonth) {
                    result.push(this.makeDateObject(dt));
                } else {
                    result.push(this.makeDateObject(dt, 'next'));
                    if (this.makePWeek(dt) == 6) {
                        break;
                    }
                }
            }
            return chunkArray(result, 7);
        },
        // gregorian date
        geDate() {
            const baseDate = this.current * 1000;
            let d = new Date(baseDate);
            return [d.getFullYear(), (d.getMonth() + 1), d.getDate()];
        },
        // persian date
        peDate() {
            const baseDate = this.current * 1000;
            let d = new Date(baseDate);
            return this.pDate.convertDate2Persian(d);
        },
        // gregorian date by value
        vgeDate() {
            const baseDate = this.val * 1000;
            let d = new Date(baseDate);
            return [d.getFullYear(), (d.getMonth() + 1), d.getDate()];
        },
        // persian date by value
        vpeDate() {
            const baseDate = this.val * 1000;
            let d = new Date(baseDate);
            return this.pDate.convertDate2Persian(d);
        },
        // current time
        cTime() {
            const baseDate = this.val * 1000;
            let d = new Date(baseDate);
            return [d.getHours(), d.getMinutes()];
        },
        mode() {
            const date = new Date(this.val * 1000); // Convert Unix timestamp to milliseconds
            const hours = date.getHours();

            if (hours >= 12) {
                return 'PM';
            } else {
                return 'AM';
            }
        },
    },
    methods: {
        onMouseEnter(obj) {
            this.hoverDate = obj.unix;
        },
        onMouseLeave() {
            this.hoverDate = null;
        },
        // clear input
        clear() {
            this.hideModal();
            this.val = null;
            this.fullData[this.xshow] = '';
        },
        // select now time
        nowSelect() {
            this.val = Math.floor(new Date() / 1000);
            this.select(this.makeDateObject(new Date()));
        },
        // handle select
        select(obj) {
            if (this.xmax != null && obj.unix > this.xmax) {
                return;
            }
            if (this.xmin != null && obj.unix < this.xmin) {
                return;
            }
            if (this.isSwiping) {
                return false;
            }
            if (obj.class == 'next') {
                this.next();
                return false;
            }
            if (obj.class == 'previous') {
                this.previous();
                return false;
            }
            // reset values
            this.onSelect(obj);
            this.fullData = obj;
            this.current = obj.unix;
            if (this.startDate == null) {
                this.startDate = obj.unix;
            } else {
                if (this.endDate == null) {
                    this.endDate = obj.unix;
                    if (this.closeOnSelect) {
                        this.canCloseModal = true;
                        this.hideModal();
                    }
                } else {

                    this.startDate = obj.unix;
                    this.endDate = null;
                }
            }

            return true;

        },
        // select year
        yearPicking(i) {
            let dt = this.current * 1000;
            dt = new Date(dt);
            // for gregorian
            if (this.tabIndex == 1) {
                dt.setFullYear(i);
                this.current = Math.floor(dt / 1000);
            } else {
                // for persian
                let cYear = parseInt(this.peDate[0]);
                let diff = ONE_YEAR * (i - cYear);
                this.current = Math.floor((dt / 1000) + diff);
            }

            this.yPicker = false;
        },
        // change gregorian current month
        gMonthPicking(i) {
            let dt = this.current * 1000;
            dt = new Date(dt);
            dt.setMonth(parseInt(i));
            this.current = Math.floor(dt / 1000);
            this.gmPicker = false;
        },
        // change persian current month
        pMonthPicking(i) {
            let dt = this.current * 1000;
            dt = new Date(dt);
            let x = 10;
            if ((i + 1) != parseInt(this.peDate[1])) {
                if ((i + 1) < parseInt(this.peDate[1])) {
                    x = -10;
                }
                // for persian find by loop for dec tolerance
                do {
                    dt.setDate(dt.getDate() + x);
                } while ((i + 1) != this.pDate.convertDate2Persian(dt)[1]);
                this.current = Math.floor(dt / 1000);
            }

            this.pmPicker = false;
        },

        // next month
        next() {
            let dt = this.current * 1000;
            dt = new Date(dt);
            // for gregorian
            if (this.tabIndex == 1) {
                dt.setMonth(dt.getMonth() + 1);
            } else {
                let currentMonth = this.pDate.convertDate2Persian(new Date(dt))[1];
                // for persian find by loop for dec tolerance
                do {
                    dt.setDate(dt.getDate() + 10);
                } while (currentMonth == this.pDate.convertDate2Persian(dt)[1]);
            }
            this.current = Math.floor(dt / 1000);
        },
        // previous month
        previous() {
            let dt = this.current * 1000;
            dt = new Date(dt);
            // for gregorian
            if (this.tabIndex == 1) {
                dt.setMonth(dt.getMonth() - 1);
            } else {

                // persian
                let currentMonth = this.pDate.convertDate2Persian(new Date(dt))[1];
                // for persian find by loop for dec tolerance
                do {
                    dt.setDate(dt.getDate() - 10);
                } while (currentMonth == this.pDate.convertDate2Persian(dt)[1]);
            }
            this.current = Math.floor(dt / 1000);
        },
        makeDateObject(dt, cls) {
            dt.setHours(this.cTime[0], this.cTime[1]);
            return {
                day: this.pDate.make2number(dt.getDate()), // day
                pDay: this.pDate.convertDate2Persian(dt)[2], // persian date
                date: dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate(), // gregorian date
                datetime: dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate() + ' ' + this.pDate.make2number(dt.getHours()) + ':' + this.pDate.make2number(dt.getMinutes()), // gregorian datetime
                pdatetime: this.pDate.convertDate2Persian(dt).join('/') + ' ' + this.pDate.make2number(dt.getHours()) + ':' + this.pDate.make2number(dt.getMinutes()), // persian date
                pdate: this.pDate.convertDate2Persian(dt).join('/'),  // persian date
                hpdatetime: this.pDate.parseHindi(this.pDate.convertDate2Persian(dt).join('/') + ' ' + this.pDate.make2number(dt.getHours()) + ':' + this.pDate.make2number(dt.getMinutes())), // persian date hindi number
                hpdate: this.pDate.parseHindi(this.pDate.convertDate2Persian(dt).join('/')),  // persian date hindi number
                weekDay: dt.getDay(), // week day
                class: cls, // class of d
                unix: Math.floor(dt / 1000) // unix time stamp
            };
        },
        // make persian week day
        makePWeek(dt) {
            let t = dt.getDay() + 1 % 7;
            if (t == 7) {
                return 0
            }
            return t;
        },
        // show month pick modal
        monthPick() {
            // gregorian
            if (this.tabIndex == 1) {
                this.gmPicker = !this.gmPicker;
                this.pmPicker = false;
            } else {
                // persian
                this.pmPicker = !this.pmPicker;
                this.gmPicker = false;
            }
        },

        // show year pick modal
        yearPick() {
            // gregorian
            if (this.tabIndex == 1) {
                this.startYear = parseInt(this.geDate[0]);
            } else {
                // persian
                this.startYear = parseInt(this.peDate[0]);
            }
            this.yPicker = !this.yPicker;
        },
        // is selected this td
        isActive(obj) {
            let r = '';
            if (obj.unix == this.startDate) {
                r = 'active-selected';
            }
            if (this.endDate != null) {
                if (obj.unix > this.startDate && obj.unix <= this.endDate) {
                    r = 'active-selected';
                }
            } else if (this.startDate != null && this.hoverDate != null) {
                if (obj.unix > this.startDate && obj.unix <= this.hoverDate) {
                    r = 'active-selected';
                }
            }
            if (this.xmax != null && obj.unix > this.xmax) {
                r += ' disabled-date';
            }
            if (this.xmin != null && obj.unix < this.xmin) {
                r += ' disabled-date';
            }
            return r;
        },
        // select hour
        pickHour(i, ignore = false) {
            let dt = new Date(this.val * 1000);
            if (ignore) {
                dt.setHours(i);
            } else {
                dt.setHours((this.mode == 'AM' ? i : (i + 12)));
            }
            dt.setMinutes(this.cTime[1]);
            this.val = Math.floor(dt.getTime() / 1000);
        },


        /**
         * drag handling for clock select
         */
        startDrag(e) {
            if (e.target.tagName != 'B') {
                this.isDragging = true;
            }
            this.dragHandle(e);
        },
        pickMinutes(e) {
            if (!this.isDragging) return;
            this.dragHandle(e);
        },
        endDrag(e) {
            this.isDragging = false;
            this.dragHandle(e);
        },
        dragHandle(e) {

            e.preventDefault();
            if (!this.isDragging) {
                return;
            }
            // calc polar system delta
            const touch = e.touches ? e.touches[0] : null;
            const eventX = touch ? touch.clientX : e.clientX;
            const eventY = touch ? touch.clientY : e.clientY;

            const rect = e.currentTarget.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;

            const deltaX = eventX - centerX;
            const deltaY = eventY - centerY;

            const r = Math.sqrt(deltaX ** 2 + deltaY ** 2);

            let theta = Math.atan2(deltaY, deltaX);
            theta = ((theta * 180 / Math.PI) + 450) % 360;

            // console.log('r:', r);
            // console.log('theta:', theta);
            if (r > 90 && r < 160) {
                const minutes = Math.floor((theta / 360) * 60);
                let dt = new Date(this.val * 1000);
                dt.setHours(dt.getHours());
                dt.setMinutes(minutes);
                this.val = Math.floor(dt / 1000);
            }
        },


        /**
         * swipe calendar next  / perv ( month / year)
         */

        startSwipe(e, touch) {
            this.isSwiping = true;
            this.canCloseModal = false;
            this.contentRect = e.currentTarget.getBoundingClientRect();
            this.startX = touch ? touch.clientX : e.clientX;
            this.startY = touch ? touch.clientY : e.clientY;
            this.swipeDirection = null;
            this.swipeDistance = 0;
            this.hasSwipedOnce = false; // Reset the swipe flag
        },
        handleSwipe(e, touch) {
            e.preventDefault();
            if (this.tabIndex == 2) {
                return false;
            }
            if (!this.startX || !this.startY) return;

            const currentX = touch ? touch.clientX : e.clientX;
            const currentY = touch ? touch.clientY : e.clientY;

            const deltaX = currentX - this.startX;
            const deltaY = currentY - this.startY;


            if (Math.abs(deltaY) > Math.abs(deltaX)) {
                this.calContainerTop = deltaY * .5;
                this.calContainerLeft = 0;
            }

            if (Math.abs(deltaY) < Math.abs(deltaX)) {
                this.calContainerTop = 0;
                this.calContainerLeft = deltaX * .5;
            }


            this.swipeDirection = Math.abs(deltaX) > Math.abs(deltaY)
                ? deltaX > 0 ? 'right' : 'left'
                : deltaY > 0 ? 'down' : 'up';

            this.swipeDistance = this.swipeDirection === 'right' || this.swipeDirection === 'left'
                ? Math.abs(deltaX)
                : Math.abs(deltaY);

            // Update content padding based on swipe distance and direction (handle 40%)
            if (this.swipeDistance > this.contentRect.width * 0.4 && !this.hasSwipedOnce) {
                this.triggerSwipe(this.swipeDirection);
                this.hasSwipedOnce = true; // Set the swipe flag to true
            }
        },
        endSwipe() {
            this.startX = 0;
            this.startY = 0;
            this.swipeDirection = null;
            this.swipeDistance = 0;
            this.calContainerTop = 0;
            this.calContainerLeft = 0;
            this.isSwiping = false;
        },
        triggerSwipe(direction) {
            // Update content padding based on swipe direction
            let y = parseInt(this.peDate[0]);
            if (this.tabIndex == 1) {
                y = parseInt(this.geDate[1]);
            }
            switch (direction) {
                case 'right':
                    this.previous();
                    break;
                case 'left':
                    this.next();
                    break;
                case 'up':
                    this.yearPicking(y + 1);
                    break;
                case 'down':
                    this.yearPicking(y - 1);
                    break;
            }
            this.endSwipe();
        },


        // change mode am/pm
        changeMode(mode) {
            // ignore AM while AM
            if (this.mode == 'AM' && mode == 'AM') {
                return;
            }
            // ignore PM while PM
            if (this.mode == 'PM' && mode == 'PM') {
                return;
            }

            if (mode == 'AM') {

                if (this.cTime[0] == 12) {
                    this.pickHour(12);
                } else {
                    this.pickHour(this.cTime[0] - 12, true);
                }
            } else {
                this.pickHour(this.cTime[0] + 12, true);
            }
        },

        convertToHuman(unix) {
            if (unix == null || unix == '') {
                return '';
            }
            let dt = new Date(unix * 1000);
            if (this.tabIndex == 0) {
                return this.pDate.parseHindi(this.pDate.convertDate2Persian(dt).join('/'));
            } else {
                return dt.getFullYear() + '-' + dt.getMonth() + '-' + dt.getDate();
            }
        },
        // hide modal
        hideModal() {
            if (this.canCloseModal) {
                this.modalShow = false;
            }
        },
        chunkArray: chunkArray,
    },
    watch: {
        vals(newValue) {
            if (this.modelValue != 'nop') {
                this.$emit('update:modelValue', newValue);
            }
        }
    }
}
</script>

<style scoped>
#vue-datepicker {
    direction: ltr;
    font-size: var(--font-size-md);
}

#dp-modal {
    position: fixed;
    inset: 0;
    z-index: var(--z-index-overlay);
    background-color: var(--color-overlay);
}

#picker {
    max-inline-size: 400px;
    min-block-size: 450px;
    margin: calc(50vh - 225px) auto;
    padding: var(--spacing-2xs);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-lg);
    background-color: var(--color-surface-raised);
    color: var(--color-text);
    font-family: var(--font-family-base);
    box-shadow: var(--shadow-lg);
    user-select: none;
}

#picker table {
    inline-size: 100%;
    margin-block-start: var(--spacing-2xs);
    border-collapse: separate;
    border-spacing: var(--spacing-3xs);
}

#picker table td,
#picker table th {
    inline-size: calc(100% / 7);
    text-align: center;
}

#picker table th {
    padding: var(--spacing-2xs) var(--spacing-3xs);
    color: var(--color-text-muted);
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-semibold);
}

#picker table td {
    padding: var(--spacing-xs) var(--spacing-3xs);
    border: 1px solid transparent;
    border-radius: var(--radius-md);
    font-variant-numeric: tabular-nums;
    cursor: pointer;
    transition: background-color var(--duration-fast) var(--easing-standard), color var(--duration-fast) var(--easing-standard);
}

#picker table td:hover {
    background-color: var(--color-hover);
}

#picker table td.next,
#picker table td.previous {
    color: var(--color-text-disabled);
}

#picker table td.disabled-date {
    background-color: var(--color-field);
    color: var(--color-text-disabled);
    text-decoration: line-through;
}

#picker table td.active-selected {
    background-color: var(--color-primary-subtle);
    color: var(--color-primary-text);
    font-weight: var(--font-weight-semibold);
}

.equal-width {
    display: grid;
    grid-auto-columns: minmax(0, 1fr);
    grid-auto-flow: column;
    gap: var(--spacing-3xs);
    text-align: center;
    cursor: pointer;
}

.equal-width div {
    padding: var(--spacing-xs) var(--spacing-2xs);
    border-radius: var(--radius-md);
    font-weight: var(--font-weight-semibold);
}

.equal-width div i {
    font-size: 1.5rem;
}

.equal-width div:hover {
    background-color: var(--color-hover);
    color: var(--color-text);
}

#vuejs-tabs {
    margin-block-end: var(--spacing-xs);
    padding: var(--spacing-3xs);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    background-color: var(--color-field);
}

#vuejs-tabs div {
    border-radius: var(--radius-sm);
    color: var(--color-text-muted);
}

#vuejs-tabs div:hover {
    color: var(--color-text);
}

#vuejs-tabs .active-tab,
#vuejs-tabs .active-tab:hover {
    background-color: var(--color-primary-subtle);
    color: var(--color-primary-text);
}

.vuejsbtn {
    padding: 1px !important;
}

#calendar-container {
    position: relative;
    min-block-size: 285px;
}

.sub-picker {
    position: absolute;
    inset: 0;
    background-color: var(--color-surface-raised);
}

.month {
    padding: 1.4rem 0 !important;
}

.year {
    padding: .97rem 0 !important;
}

#bottom-bar {
    display: grid;
    grid-template-columns: 1fr 2fr 1fr;
    margin-block-start: var(--spacing-2xs);
    border-block-start: 1px solid var(--color-border);
    text-align: center;
}

#bottom-bar > div {
    padding: var(--spacing-xs) var(--spacing-2xs);
}

.vuejs-btn {
    display: block;
    padding: var(--spacing-2xs);
    border: 1px solid var(--color-border-strong);
    border-radius: var(--radius-md);
    background-color: transparent;
    color: var(--color-text-muted);
    cursor: pointer;
}

.vuejs-btn:hover {
    background-color: var(--color-hover);
    color: var(--color-text);
}

.vuejs-btn i {
    font-size: 1.25rem;
}

.vuejs-btn.active-selected {
    border-color: var(--color-primary-edge);
    background-color: var(--color-primary);
    color: var(--color-text-on-primary);
}

.vuejs-btn:focus-visible,
.equal-width div:focus-visible,
#picker table td:focus-visible,
.number-hours span i b:focus-visible {
    outline: 2px solid var(--color-focus-ring);
    outline-offset: 2px;
}

.centered {
    display: flex;
    align-items: center;
    justify-content: center;
}

.centered span {
    display: inline-block;
    color: var(--color-text-muted);
    font-size: var(--font-size-xs);
    font-variant-numeric: tabular-nums;
}

#clock {
    padding: 33.5px 65px;
}

#circle {
    position: absolute;
    inset-inline-start: calc(50% - 3px);
    inset-block-start: calc(50% - 3px);
    z-index: 5;
    inline-size: 6px;
    block-size: 6px;
    border-radius: var(--radius-full);
    background-color: var(--color-primary-text);
}

.wrapper {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    inline-size: 255px;
    block-size: 255px;
    border-radius: 50%;
}

.bar-seconds,
.number-hours {
    position: absolute;
    inline-size: 100%;
    block-size: 100%;
    border-radius: 50%;
}

.bar-seconds span {
    position: absolute;
    inset: -20px;
    text-align: center;
    transform: rotate(calc(var(--index) * 6deg));
    pointer-events: none;
}

.bar-seconds span i {
    display: inline-block;
    inline-size: 2px;
    block-size: 12px;
    border-radius: 2px;
    background-color: var(--color-border-strong);
    font-style: normal;
    pointer-events: none;
}

.bar-seconds span:nth-child(5n) i { /* 5n pour dire tout les mutliples de 5 */
    inline-size: 6px;
    block-size: 18px;
    background-color: var(--color-text-muted);
    transform: translateY(1px);
}

.number-hours span {
    position: absolute;
    inset: 6px;
    text-align: center;
    transform: rotate(calc(var(--index) * 30deg));
    pointer-events: none;
}

.number-hours span i {
    color: var(--color-text);
    font-size: 1.125rem;
    font-style: normal;
    transform: rotate(calc(var(--index) * -30deg));
    pointer-events: none;
}

.number-hours span i b {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
    inline-size: 40px;
    block-size: 40px;
    padding: 2px;
    border-radius: var(--radius-full);
    color: var(--color-text);
    font-weight: var(--font-weight-medium);
    text-decoration: none;
    pointer-events: all;
}

.number-hours span i b:hover {
    background-color: var(--color-hover);
    color: var(--color-text);
}

.number-hours span i b.active-selected {
    background-color: var(--color-primary);
    color: var(--color-text-on-primary);
}

.hands-box {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
}

.hands-box .hand {
    position: absolute;
    display: flex;
    justify-content: center;
    border-radius: 50%;
}

.hands-box .hand i {
    display: inline-block;
    border-radius: 50%;
    transform-origin: bottom;
}

.hands-box .hours {
    inline-size: 180px;
    block-size: 180px;
}

.hands-box .hours i {
    inline-size: 8px;
    block-size: 90px;
    background-color: var(--color-text);
}

.hands-box .minutes {
    inline-size: 275px;
    block-size: 275px;
}

.hands-box .minutes i {
    inline-size: 6px;
    block-size: 140px;
    border-radius: 2px;
    background-color: var(--color-primary-text);
}

#modes {
    position: absolute;
    inset-inline-start: 5px;
    inset-block-start: 5px;
}

#modes .vuejs-btn {
    inline-size: 40px;
    margin-block-end: var(--spacing-2xs);
    padding: var(--spacing-xs) var(--spacing-2xs);
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-semibold);
    text-align: center;
}

#time {
    position: absolute;
    inset-inline-end: 5px;
    inset-block-start: 5px;
    font-size: var(--font-size-xl);
    font-weight: var(--font-weight-semibold);
    font-variant-numeric: tabular-nums;
}

@media (prefers-reduced-motion: reduce) {
    #picker table td {
        transition: none;
    }
}
</style>
