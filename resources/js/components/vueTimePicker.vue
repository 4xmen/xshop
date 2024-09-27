<template>
    <div class="time-picker" >
        <div class="input-group mb-3">
            <div class="input-group-prepend" id="vue-search-btn" @click="modalShow">
                <span class="input-group-text" id="basic-addon1">
                    <i class="ri-time-line"></i>
                </span>
            </div>
            <input type="text" @focus="modalShow" :placeholder="xtitle" readonly :value="formattedTime" class="form-control text-center">
        </div>
        <input type="hidden" :value="val" :name="this.xname">
        <div id="tp" v-if="modal">
            <div id="highlight"></div>
            <div class="row text-center">

                <div class="col"
                     @touchstart="startDrag('minute', $event)"
                     @mousedown="startDrag('minute', $event)"
                     @wheel="handleScroll('minute',$event)"
                >
                    <div>
                        <ul :style="mTop">
                            <li v-for="i in [...Array(60).keys()]" :key="`m-${i}`" :class="mClass(i)">
                                {{ (i).toString().padStart(2, '0') }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col"
                     @touchstart="startDrag('hour', $event)"
                     @mousedown="startDrag('hour', $event)"
                     @wheel="handleScroll('hour',$event)"
                >
                    <div>
                        <ul :style="hTop">
                            <li v-for="i in this.amPm?12:[...Array(24).keys()]" :key="`h-${i}`" :class="hClass(i)">
                                {{ i.toString().padStart(2, '0') }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col" v-if="amPm"
                     @touchstart="startDrag('ampm', $event)"
                     @mousedown="startDrag('ampm', $event)"
                     @wheel="handleScroll('ampm',$event)"
                >
                    <div>
                        <ul :style="amTop" @click="ap = Math.abs(ap - 1)">
                            <li :class="ap === 0 ? 'active' : ''">AM</li>
                            <li :class="ap === 1 ? 'active' : ''">PM</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "time-picker",
    data() {
        return {
            h: 1,
            m: 0,
            ap: 0, // am or pm
            startY: 0,
            activeColumn: null,
            isDragging: false,
            modal: false,
        };
    },
    emits: ['update:modelValue'],
    props: {
        modelValue: {
            type: [Number, String],
            default: 'nop',
        },
        xname: {
            default: "",
            type: String,
        },
        xtitle: {
            default: "",
            type: String,
        },
        xvalue: {
            default: "",
            type: String,
        },
        xid: {
            default: "",
            type: String,
        },
        amPm: {
            default: true,
            type: Boolean,
        },
        tolerance: {
            default: 50, // drag tolerance
        }
    },
    computed: {
        maxHour() {
            return this.amPm ? 12 : 24;
        },
        amTop() {
            return `top: ${this.ap ? 40 : 60}px;`;
        },
        hTop() {
            return `top: ${(this.h - 2.5 - (this.amPm)) * -25}px`;
        },
        mTop() {
            return `top: ${(this.m - 2.5) * -25}px`;
        },
        formattedTime() {
            const hour = this.amPm ? (this.h === 12 ? 12 : this.h % 12) : this.h;
            const minute = this.m.toString().padStart(2, '0');
            const period = this.amPm ? (this.ap === 0 ? 'AM' : 'PM') : '';
            return `${hour}:${minute} ${period}`.trim();
        },
        val() {
            let val = (this.h * 3600) + (this.m * 60);

            // Assuming this.amPm is a boolean, where true means PM and false means AM.
            if (this.ap == 1) {
                if (this.h !== 12) { // if it's PM and not 12 PM, we add 12 hours to convert to 24-hour format
                    val += 12 * 3600;
                }
            } else {
                if (this.h === 12) { // if it's AM and it's 12 AM, we need to reset it to 0 hours
                    val -= 12 * 3600; // removing 12 hours to convert 12 AM to 0 hours
                }
            }

            this.$emit('update:modelValue', val);
            return val;
        }
    },
    methods: {
        handleScroll(column,e){
            e.preventDefault();
            let change = -1;
            if (e.deltaY > 0){
                change = 1;
            }
            this.changeHandle(column,change);

        },
        changeHandle(column, change){
            if (column == 'ampm'){
                if (change == 1) {
                    this.ap = 1;
                } else if (change == -1) {
                    this.ap = 0;
                }
            }else if (column === 'minute') {
                this.m += change;
                if (this.m < 0) {
                    this.m = 0;
                }
                if (this.m > 59) {
                    this.m = 59;
                }
            } else if (column === 'hour') {
                this.h += change;
                if (this.amPm) {
                    if (this.h < 1) {
                        this.h = 1;
                    }
                    if (this.h > this.maxHour) {
                        this.h = this.maxHour;
                    }
                } else {
                    if (this.h < 0) {
                        this.h = 0;
                    }
                    if (this.h > this.maxHour - 1) {
                        this.h = this.maxHour - 1;
                    }
                }
            }
        },
        modalShow() {
            this.modal = true;
            document.addEventListener('click', this.handleModal);
        },
        handleModal(event){
            const timeElement = document.querySelector('.time-picker');

            if (timeElement && !timeElement.contains(event.target)) {
                this.modal = false;
                document.removeEventListener('click', this.handleModal);
            }
        },
        mClass(i) {
            if (i === this.m) return 'active';
            if ((i + 2) % 60 === this.m) return 'before';
            if ((i - 2 + 60) % 60 === this.m) return 'after';
            if ((i + 3) % 60 === this.m) return 'before2';
            if ((i - 3 + 60) % 60 === this.m) return 'after2';
        },
        hClass(i) {
            if (i === this.h) return 'active';
            if ((i + 2) === this.h) return 'before';
            if ((i - 2 + this.maxHour) % this.maxHour === this.h) return 'after';
            if ((i + 3) === this.h) return 'before2';
            if ((i - 3 + this.maxHour) % this.maxHour === this.h) return 'after2';
        },
        startDrag(column, event) {
            this.isDragging = true;
            this.startY = event.type.startsWith('touch') ? event.touches[0].clientY : event.clientY;
            this.activeColumn = column;
            document.addEventListener('mousemove', this.drag)
            document.addEventListener('touchmove', this.drag)
            document.addEventListener('mouseup', () => {
                document.removeEventListener('mousemove', this.drag);
                document.removeEventListener('touchend', this.drag);
                this.endDrag();
            });
            document.addEventListener('touchend', () => {
                document.removeEventListener('mousemove', this.drag);
                document.removeEventListener('touchend', this.drag);
                this.endDrag();
            });
        },
        drag(event) {
            event.preventDefault();
            let column = this.activeColumn;
            if (!this.isDragging || this.activeColumn !== column) return;

            const currentY = event.type.startsWith('touch') ? event.touches[0].clientY : event.clientY;
            const deltaY = this.startY - currentY;
            // console.log(deltaY);
            let change = Math.round(deltaY / this.tolerance);
            // console.log(change,currentY);

            this.changeHandle(column,change);

            if (change != 0) {
                this.startY = currentY;
            }
        },
        endDrag() {
            this.isDragging = false;
            this.activeColumn = null;
        },
        calc(secs) {
            if (this.amPm) {
                // am/pm
                const totalMinutes = Math.floor(secs / 60);
                this.h = Math.floor(secs / 3600) % 24; // total minutes in 24 hours
                this.m = totalMinutes % 60; // remaining minutes

                if (this.h >= 12) {
                    this.ap = 1;
                    if (this.h > 12) {
                        this.h -= 12; // convert to 12-hour format
                    }
                } else {
                    this.ap = 0;
                    if (this.h === 0) {
                        this.h = 12; // 12 AM is 0 hours in 24h format
                    }
                }
            } else {
                // 24h
                this.h = Math.floor(secs / 3600) % 24; // Ensure hour is in 0-23 range
                this.m = Math.floor(secs / 60) % 60;
            }
        },
    }, beforeMount() {
        let x;
        if (this.modelValue !== 'nop') {
            x = this.modelValue;
        } else {
            x = this.xvalue;
        }
        this.calc(x);

        // window.addEventListener('scroll', this.handleScroll);
    }
};
</script>


<style scoped>
.time-picker {
    position: relative;
    user-select: none;
    touch-action: none;

    #highlight {
        position: absolute;
        left: 0;
        right: 0;
        z-index: 3;
        background: rgba(173, 255, 47, 0.44);
        height: 45px;
        top: 75px;
    }

    #tp {
        position: absolute;
        top: 100%;
        width: 275px;
        background: #282d46;
        inset-inline-start: 0;
        padding: 1rem;

        border: 1px solid rgba(192, 192, 192, 0.46);
        border-radius: 7px;
        z-index: 3;
        height: 200px;
        overflow: hidden;

        .row {
            position: relative;
        }

        .col {
            padding: 0;
            position: relative;
            z-index: 7;

            div {
                height: 200px;
                position: relative;
                z-index: 4;

                ul {
                    list-style: none;
                    position: absolute;

                    li {
                        height: 25px;
                    }
                }
            }
        }
    }

    .active {
        font-size: 30px;
        height: 45px !important;
    }

    .before {
        opacity: .75;
        transform: rotateX(-35deg);
    }

    .after {
        opacity: .75;
        transform: rotateX(+35deg);
    }

    .before2 {
        opacity: .35;
        transform: rotateX(-55deg);
    }

    .after2 {
        opacity: .35;
        transform: rotateX(+55deg);
    }
}
</style>
