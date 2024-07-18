<template>
    <div id="gfxer">
        <div class="row">
            <div class="col-xl-3">
                <div class="item-list mb-3">
                    <h3 class="p-3">
                        <i class="ri-brush-2-line"></i>
                        GFX
                    </h3>
                    <template v-for="(v,i) in values" >
                        <div v-if="v != undefined" class="p-2 item-gfx">
                            <div class="float-end"
                                 v-if="i == 'background' || i == 'primary' || i == 'secondary' || i == 'text'">
                                <input type="color" v-model="values[i]" class="form-control-color">
                            </div>
                            <label class="pt-2 mb-1">
                                {{ titles[i] }}
                            </label>
                            <br>
                            <template v-if="i == 'border-radius'">
                                <border-radios-input v-model="values[i]"></border-radios-input>
                            </template>
                            <template v-if="i == 'shadow'">
                                <shadow-input v-model="values[i]"></shadow-input>
                            </template>
                            <template v-if="i == 'font'">
                                <select v-model="values[i]" class="form-control">
                                    <option value="Vazir"> Vazir</option>
                                </select>
                            </template>
                            <template v-if="i == 'container'">
                                <select v-model="values[i]" class="form-control">
                                    <option value="container"> Container</option>
                                    <option value="container-fluid"> Container fluid</option>
                                </select>
                            </template>

                            <input :name="'gfx['+i+']'" :type="_dbg_" :value="v">
                        </div>
                    </template>
                    <div class="p-2">
                        <select v-model="device" class="form-control">
                            <option value="desktop"> Desktop</option>
                            <option value="mobile"> Mobile</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xl-9">
                <div id="browser" :style="generalStyle" v-if="device != 'mobile'">
                    <div id="bar">
                        Browser
                    </div>
                    <div id="b-content">
                        <div :class="values.container">
                            <div class="row" id="items-icon">
                                <div class="col-md-4">
                                    <i class="ri-twitter-line"
                                       :style="`color: ${values.primary};`"></i>
                                    <h3 :style="`color: ${values.secondary};`">
                                        Social media
                                    </h3>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aperiam doloremque
                                        eligendi reprehenderit voluptas? Ab amet autem doloremque, eius et harum magnam
                                        maxime minima odio pariatur quaerat soluta temporibus velit.
                                    </p>
                                    <a class="btn-read-more"
                                       :style="`box-shadow: ${values.shadow} ;
                                       border-radius: ${values['border-radius']} ;
                                       border-color: ${values.primary};
                                       color: ${values.primary};`">
                                        Read more
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <i class="ri-mail-line"
                                       :style="`color: ${values.primary};`"></i>
                                    <h3 :style="`color: ${values.secondary};`">
                                        Contact
                                    </h3>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aperiam doloremque
                                        eligendi reprehenderit voluptas? Ab amet autem doloremque, eius et harum magnam
                                        maxime minima odio pariatur quaerat soluta temporibus velit.
                                    </p>
                                    <a class="btn-read-more"
                                       :style="`box-shadow: ${values.shadow} ;
                                       border-radius: ${values['border-radius']} ;
                                       border-color: ${values.primary};
                                       color: ${values.primary};`">
                                        Read more
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <i class="ri-brush-4-line"
                                       :style="`color: ${values.primary};`"></i>
                                    <h3 :style="`color: ${values.secondary};`">
                                        Design
                                    </h3>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aperiam doloremque
                                        eligendi reprehenderit voluptas? Ab amet autem doloremque, eius et harum magnam
                                        maxime minima odio pariatur quaerat soluta temporibus velit.
                                    </p>
                                    <a class="btn-read-more"
                                       :style="`box-shadow: ${values.shadow} ;
                                       border-radius: ${values['border-radius']} ;
                                       border-color: ${values.primary};
                                       color: ${values.primary};`">
                                        Read more
                                    </a>
                                </div>
                            </div>

                            <div id="big-box" :style="`box-shadow: ${values.shadow} ;
                                       border-radius: ${values['border-radius']} ;
                                        background: linear-gradient(49deg, ${values.primary} 42%, ${values.secondary} 100%);`">
                                <h3 class="diff">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate iste ut
                                    veritatis?
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="mobile" :style="generalStyle" v-if="device == 'mobile'">
                    <div id="mobile-top" :style="`background: ${lighter};`">
                        <div class="diff p-1 d-flex align-items-center justify-content-between ">
                            <span>
                                <i class="ri-wifi-line"></i>
                            </span>
                            <span>
                                {{ nowTime }}
                            </span>
                            <i class="ri-battery-low-line"></i>
                        </div>
                        <div :style="`background: ${values.primary};`">
                            <div class="diff p-2">
                                {{ tempUrl }}
                            </div>
                        </div>
                    </div>
                    <div id="m-content" :class="values.container">
                        <div class="row" id="items-icon">
                            <div class="col-md-12">
                                <i class="ri-twitter-line"
                                   :style="`color: ${values.primary};`"></i>
                                <h3 :style="`color: ${values.secondary};`">
                                    Social media
                                </h3>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aperiam doloremque
                                    eligendi reprehenderit voluptas? Ab amet autem doloremque, eius et harum magnam
                                    maxime minima odio pariatur quaerat soluta temporibus velit.
                                </p>
                                <a class="btn-read-more"
                                   :style="`box-shadow: ${values.shadow} ;
                                       border-radius: ${values['border-radius']} ;
                                       border-color: ${values.primary};
                                       color: ${values.primary};`">
                                    Read more
                                </a>
                            </div>
                            <div class="col-12">
                                <i class="ri-mail-line"
                                   :style="`color: ${values.primary};`"></i>
                                <h3 :style="`color: ${values.secondary};`">
                                    Contact
                                </h3>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aperiam doloremque
                                    eligendi reprehenderit voluptas? Ab amet autem doloremque, eius et harum magnam
                                    maxime minima odio pariatur quaerat soluta temporibus velit.
                                </p>
                                <a class="btn-read-more"
                                   :style="`box-shadow: ${values.shadow} ;
                                       border-radius: ${values['border-radius']} ;
                                       border-color: ${values.primary};
                                       color: ${values.primary};`">
                                    Read more
                                </a>
                            </div>
                            <div class="col-12">
                                <i class="ri-brush-4-line"
                                   :style="`color: ${values.primary};`"></i>
                                <h3 :style="`color: ${values.secondary};`">
                                    Design
                                </h3>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aperiam doloremque
                                    eligendi reprehenderit voluptas? Ab amet autem doloremque, eius et harum magnam
                                    maxime minima odio pariatur quaerat soluta temporibus velit.
                                </p>
                                <a class="btn-read-more"
                                   :style="`box-shadow: ${values.shadow} ;
                                       border-radius: ${values['border-radius']} ;
                                       border-color: ${values.primary};
                                       color: ${values.primary};`">
                                    Read more
                                </a>
                            </div>
                        </div>

                        <div id="big-box" :style="`box-shadow: ${values.shadow} ;
                                       border-radius: ${values['border-radius']} ;
                                        background: linear-gradient(49deg, ${values.primary} 42%, ${values.secondary} 100%);`">
                            <h3 style="filter: invert(1);mix-blend-mode: difference;">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate iste ut
                                veritatis?
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import BorderRadiosInput from "./BorderRadiosInput.vue";
import ShadowInput from "./ShadowInput.vue";

export default {
    name: "gfxer",
    components: {
        BorderRadiosInput,
        ShadowInput
    },
    data: () => {
        return {
            _dbg_: 'hidden',
            values: {},
            titles: {},
            device: 'desktop', // desktop
        }
    },
    props: {
        items: {},
    },
    mounted() {
        for (const i in this.items) {
            let item = this.items[i];
            this.titles[item.key] = item.label;
            this.values[item.key] = item.value;
        }

        console.log(this.items);
    },
    computed: {
        generalStyle() { //
            let css = '';
            console.log();
            if (this.values.background != null) {
                css += 'background-color: ' + this.values.background + ';';
            }
            if (this.values.text != null) {
                css += 'color: ' + this.values.text + ';';
            }

            return css;
        },
        tempUrl() {
            return window.location.hostname;
        },
        nowTime() {
            const dt = new Date();
            return dt.getHours() + ':' + dt.getMinutes();
        },
        lighter() {
            if (this.values.primary != undefined) {
                return this.lightenColor(this.values.primary);
            }
        }

    },
    methods: {
        lightenColor(col, amt = 20) {
            var usePound = false;
            if (col[0] == "#") {
                col = col.slice(1);
                usePound = true;
            }

            var num = parseInt(col, 16);

            var r = (num >> 16) + amt;

            if (r > 255) r = 255;
            else if (r < 0) r = 0;

            var b = ((num >> 8) & 0x00FF) + amt;

            if (b > 255) b = 255;
            else if (b < 0) b = 0;

            var g = (num & 0x0000FF) + amt;

            if (g > 255) g = 255;
            else if (g < 0) g = 0;

            return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16);
        }
    }
}
</script>

<style scoped>
#gfxer {

}

#mobile {
    width: 400px;
    height: 800px;
    border-radius: 20px;
    border: 4px solid gray;
    background: #fff;
    overflow-y: auto;
}

#m-content {
    border-radius: 20px;
    overflow: hidden;
}

#browser {
    border-radius: 7px;
    border: 4px solid silver;
    min-height: 80vh;
    background: #fff;
    overflow-y: auto;
    overflow-x: hidden;

    #bar {
        display: block;
        background: silver;
        position: relative;
        text-align: center;
        padding-top: 3px;

        height: 30px;

        &:before {
            content: ' ';
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: red;
            position: absolute;
            top: 5px;
            right: 5px;

        }

        &:after {
            content: ' ';
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: #00d75c;
            position: absolute;
            top: 5px;
            right: 35px;

        }
    }
}

.item-gfx:hover {
    background: #ffffff22;
}

#items-icon {
    text-align: center;

    i {
        font-size: 75px;
    }

    p {
        text-align: justify;
    }

    .btn-read-more {
        border: 1px solid gray;
        display: block;
        padding: 5px;
        box-shadow: var(--shadow);
    }
}

#big-box {
    margin-top: 1rem;
    padding: 3rem;
}

.diff {
    filter: invert(1);
    mix-blend-mode: difference;
}
</style>
