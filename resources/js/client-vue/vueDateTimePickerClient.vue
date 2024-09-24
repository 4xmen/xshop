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
                    <div v-if="timepicker" :class="tabIndex == 2?'active-tab':''" @click="tabIndex = 2;">
                        {{ tTitle }}
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
                                    <td v-for="d in week" :class="d.class +' '+ isActive(d)" :title="d.date"
                                        @click="select(d)">
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
                                    <td v-for="d in week" :class="d.class +' '+ isActive(d) " :title="d.pdate"
                                        @click="select(d)">
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
                        <span v-if="pDate != null && '1970-0-1' != vgeDate.join('-')">
                            [{{ pDate.parseHindi(vpeDate.join('/')) }}]  [{{ vgeDate.join('-') }}]
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
            <input @focus="modalShow = true" :id="xid" :placeholder="xtitle"
                   :class="getClass" type="text"
                   :value="(val == null || val == ''?'':selectedDateTime)">
            <input type="hidden" :name="xname" :value="val">
        </div>
    </div>
</template>

<script>

import persianDate from './../components/libs/persian-date.js';

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
            val: null, // selected value
            pWeekDays: ['ش', 'ی', 'د', 'س', 'چ', 'پ', 'آ'],
            gWeekDays: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            pMonths: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
            gMonths: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        }
    },
    emits: ['update:modelValue'],
    props: {
        modelValue: {
            default: NaN,
        },
        xvalue: {
            default: null,
            type: Number,
        },
        xmax: {
            default: null,
            type: Number,
        },
        xmin: {
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
        tTitle: {
            default: 'Time',
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
    },
    mounted() {
        this.pDate = new persianDate();
        let dt;
        // check value changed by user or not, then ignore xvalue
        if (this.val == null) {


            if (!isNaN(this.modelValue)) {
                dt = new Date(parseInt(this.modelValue) * 1000);
                if (this.modelValue == null || this.modelValue == '' || this.modelValue == 'null') {
                    dt = new Date();
                    this.val = null;
                    this.current = Math.floor(new Date() / 1000);
                } else {
                    this.current = new Date(parseInt(this.modelValue));
                    this.val = this.modelValue;
                }
            } else {
                dt = new Date(parseInt(this.xvalue) * 1000);
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
        selectedDateTime() {
            // fullData[xshow]
            const dt = new Date(this.val * 1000);
            return this.makeDateObject(dt)[this.xshow];
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
            return [d.getFullYear(), d.getMonth(), d.getDate()];
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
            return [d.getFullYear(), d.getMonth(), d.getDate()];
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
            this.val = obj.unix;
            this.fullData = obj;
            this.current = this.val = obj.unix;
            if (this.closeOnSelect) {
                this.canCloseModal = true;
                this.hideModal();
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
                date: dt.getFullYear() + '-' + dt.getMonth() + '-' + dt.getDate(), // gregorian date
                datetime: dt.getFullYear() + '-' + dt.getMonth() + '-' + dt.getDate() + ' ' + this.pDate.make2number(this.cTime[0]) + ':' + this.pDate.make2number(this.cTime[1]), // gregorian datetime
                pdatetime: this.pDate.convertDate2Persian(dt).join('/') + ' ' + this.pDate.make2number(this.cTime[0]) + ':' + this.pDate.make2number(this.cTime[1]), // persian date
                pdate: this.pDate.convertDate2Persian(dt).join('/'),  // persian date
                hpdatetime: this.pDate.parseHindi(this.pDate.convertDate2Persian(dt).join('/') + ' ' + this.pDate.make2number(this.cTime[0]) + ':' + this.pDate.make2number(this.cTime[1])), // persian date hindi number
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
            let dt = new Date(this.val * 1000);
            let r = '';
            if (dt.getFullYear() + '-' + dt.getMonth() + '-' + dt.getDate() == obj.date) {
                r = 'active-selected';
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

        selfUpdate() {
            let dt;
            // check value changed by user or not, then ignore xvalue
            if (this.val == null) {
                dt = new Date(parseInt(this.xvalue) * 1000);
                if (this.xvalue == null || this.xvalue == '' || this.xvalue == 'null') {
                    dt = new Date();
                    this.val = null;
                    this.current = Math.floor(new Date() / 1000);
                } else {
                    this.current = new Date(parseInt(this.xvalue));
                    this.val = this.xvalue;
                }
            } else {
                this.current = this.val;
            }
            // this.fullData = this.makeDateObject(dt);
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
        val(newValue) {
            if (!isNaN(this.modelValue)) {
                this.$emit('update:modelValue', newValue);
            }
        }
    }
}
</script>

<style scoped>


#vue-datepicker {
    font-size: 12pt;
    direction: ltr;
}

#dp-modal {
    position: fixed;
//display: none; left: 0; right: 0; top: 0; bottom: 0; z-index: 999; background: #00000033; backdrop-filter: blur(4px);
}

#picker {
    max-width: 400px;
    min-height: 450px;
    margin: calc(50vh - 225px) auto;
    background: #ffffffdd;
    backdrop-filter: blur(4px);
    user-select: none;
    color: black;
    padding: 5px;
    font-family: 'Vazir', 'Vazirmatn', sans-serif;
}

#picker table {
    border: 1px solid black;
    width: 100%;
    margin-top: 5px;
}

#picker table td, #picker table th {
    border: 1px solid silver;
    width: calc(100% / 7);
    text-align: center;
    padding: 7px;
    transition: 500ms;
}

#picker table td:hover {
    background: deepskyblue;
    cursor: pointer;
}

#picker .next, #picker .previous {
    color: gray;
}

.equal-width {
    display: grid;
    grid-auto-columns: minmax(0, 1fr);
    grid-auto-flow: column;
    text-align: center;
    cursor: pointer;
}

.equal-width div {
    padding: .5rem 5px;
    font-weight: 800;
}

.equal-width div i {
    font-size: 25px;
}

#bottom-bar {
    display: grid;
    grid-template-columns: 1fr 2fr 1fr;
    text-align: center;
}

#bottom-bar > div {
    padding: 7px 4px;
}

#vuejs-tabs {
    border: 1px solid gray;
    margin-bottom: .5rem;
}

.equal-width div:hover {
    background: teal;
    color: white;;
}

.active-tab {
    background: deepskyblue;
    color: white;
}

.vuejsbtn {
    padding: 1px !important;
}

#calendar-container {
    position: relative;
    min-height: 285px;
}

.sub-picker {
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    right: 0;
    background: white;
}

.month {
    padding: 1.4rem 0 !important;
}

.year {
    padding: .97rem 0 !important;
}

.vuejs-btn {
    padding: 3px;
    background: silver;
    display: block;
    cursor: pointer;
}

.vuejs-btn:hover {
    background: deepskyblue;
    color: white;
}

.vuejs-btn i {
    font-size: 20px;
}

.centered {
    display: flex;
    align-items: center;
    justify-content: center;
}

.centered span {
    margin-top: 6px;
    display: inline-block;
}

.active-selected {
    background: teal;
    color: yellow !important;
}

#clock {
    padding: 33.5px 65px;
}

#circle {
    position: absolute;
    background: deepskyblue;
    width: 6px;
    height: 6px;
    left: calc(50% - 3px);
    top: calc(50% - 3px);
    border-radius: 50%;
    z-index: 5;
}

.wrapper {
    position: relative;
    width: 255px;
    height: 255px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.bar-seconds,
.number-hours {
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
}

.bar-seconds span {
    position: absolute;
    transform: rotate(calc(var(--index) * 6deg));
    inset: -20px;
    text-align: center;
    pointer-events: none;
}

.bar-seconds span i {
    display: inline-block;
    width: 2px;
    height: 12px;
    background: deepskyblue;
    border-radius: 2px;
    box-shadow: 0 0 10px deepskyblue;
    pointer-events: none;
    font-style: normal;
}

.bar-seconds span:nth-child(5n) i { /* 5n pour dire tout les mutliples de 5 */
    width: 6px;
    height: 18px;
    transform: translateY(1px);
}

.number-hours span {
    position: absolute;
    transform: rotate(calc(var(--index) * 30deg));
    inset: 6px;
    text-align: center;
    pointer-events: none;
}

.number-hours span i {
    font-size: 25px;
    color: deepskyblue;
    transform: rotate(calc(var(--index) * -30deg));
    pointer-events: none;
    font-style: normal;
}

.number-hours span i b {
    text-decoration: none;
    color: deepskyblue;
    pointer-events: all;
    display: inline-block;
    width: 40px;
    border-radius: 50%;
    height: 40px;
    box-sizing: border-box;
    padding: 2px;
    font-weight: 400;
}

.number-hours span i b:hover {
    background: teal;
    color: white;
}

.hands-box {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    pointer-events: none;
}

.hands-box .hand {
    position: absolute;
    border-radius: 50%;
    display: flex;
    justify-content: center;
}

.hands-box .hand i {
    display: inline-block;
    transform-origin: bottom;
    border-radius: 50%;
    box-shadow: 0 0 10px deepskyblue;
}

.hands-box .hours {
    width: 180px;
    height: 180px;
}

.hands-box .hours i {
    width: 8px;
    height: 90px;
    background: deepskyblue;
}

.hands-box .minutes {
    width: 275px;
    height: 275px;
}

.hands-box .minutes i {
    width: 6px;
    height: 140px;
    background: dodgerblue;
    border-radius: 2px;
}

#modes {
    position: absolute;
    left: 5px;
    top: 5px;
}

#modes .vuejs-btn {
    padding: 5px;
    width: 40px;
    text-align: center;
    padding-top: 10px;
}

#time {
    position: absolute;
    right: 5px;
    top: 5px;
    font-size: 25px;
}

.disabled-date {
    background: silver;
}
</style>
