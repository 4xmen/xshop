<template>
    <div class="mp4-player" ref="mainPlayer">

        <!-- Poster element -->
        <img :src="cover" alt="video cover" class="poster" v-if="!started" @click="startNow">


        <!-- Poster element -->
        <div class="start" @click="startNow" v-if="!started">
            <i class="ri-play-circle-line"></i>
        </div>

        <!-- Video element -->
        <video ref="p" :src="asset" class="video" @click="playPause" :poster="cover" :style="videoStyle" ></video>

        <!-- Seekbar -->
        <div class="seek-container">
            <div ref="seekbar" class="seekbar" @click="seek">
                <div class="progress-seek" :style="progressPercent"></div>
            </div>
        </div>

        <!-- Player buttons -->
        <div class="player-buttons" dir="ltr">
            <!-- Current time -->
            <div>{{ currentTime }}</div>

            <!-- Rewind 10s -->
            <button type="button" class="rw p-btn" @click="timeOffset(-10)" v-if="pageAspectRatio > 1">
                <i class="ri-rewind-line"></i>
            </button>

            <!-- Speed change -->
            <button type="button" class="sp p-btn" @click="speedChange" v-if="pageAspectRatio > 1">
                <i class="ri-speed-up-line"></i>
            </button>

            <!-- Play / Pause -->
            <button type="button" class="play-pause" @click="playPause">
                <i class="ri-play-line" v-if="!isPlay"></i>
                <i class="ri-pause-line" v-if="isPlay"></i>
            </button>

            <!-- Stop -->
            <button type="button" class="stop p-btn" @click="stopNow">
                <i class="ri-stop-line"></i>
            </button>

            <!-- Forward 10s -->
            <button type="button" class="sp p-btn" @click="timeOffset(10)" v-if="pageAspectRatio > 1">
                <i class="ri-speed-line"></i>
            </button>

            <!-- Fullscreen -->
            <button type="button" class="sp p-btn" @click="fullScreen">
                <i class="ri-fullscreen-line"></i>
            </button>

            <!-- Full time -->
            <div>{{ fullTime }}</div>
        </div>
    </div>
</template>

<script>
export default {
    name: "video-player",
    data: () => ({
        isInited: false,
        link: '',
        currentTime: '00:00',
        fullTime: '00:00',
        isPlay: false,
        full: 0,
        current: 0,
        speed: 2,
        started: false,
        speeds: [.5, .75, 1.0, 1.25, 1.5, 1.75, 2.0],
        aspectRatio: 1,
        pageAspectRatio: 1,
        refreshKey: 0,
    }),
    props: {
        fixSize: { type: Boolean, default: true },
        asset: { required: true },
        cover: { default: null },
    },
    mounted() {
        window.addEventListener('load', () => {
            setTimeout(() => {
                try {
                    this.link = this.asset;
                    document.querySelector('#video-preview-botz').style.display = 'none';
                } catch(e) {

                }
            }, 500);
        });
        this.pageAspectRatio = window.innerWidth / window.innerHeight;

        setInterval(this.updatePlayer, 300);


        const v = this.$refs.p;
        v.addEventListener("loadedmetadata", () => {
            const width = v.videoWidth;
            const height = v.videoHeight;
            this.aspectRatio = width / height;
        });
    },
    computed: {
        videoStyle() {
            this.pageAspectRatio = window.innerWidth / window.innerHeight;
            let finalCSS = '';
            if( this.started ){
                console.log(this.aspectRatio);
                if( this.aspectRatio <= 1 ){
                    // portrait
                    if( this.pageAspectRatio < 1 ){
                        finalCSS = "width:100%;";
                    }else{
                        // desktop
                        finalCSS = "height:50vh !important; width: auto !important;";
                    }
                }else{
                    // landscape
                }

            }else{
                // hide not started
                finalCSS =  "height:0;";
            }

            finalCSS = finalCSS + ';opacity:0.99'+this.refreshKey;
            console.log('final',finalCSS);
            return finalCSS;
        },
        progressPercent() {
            if (this.full != 0) {
                return `width:${(this.current * 100) / this.full}%;`;
            }
            return 'width: 0%;';
        }
    },
    methods: {
        startNow() {
            this.started = true;
            this.playPause();
        },
        fullScreen() { this.$refs.p.requestFullscreen(); },
        speedChange() {
            this.speed++;
            if (this.speed === this.speeds.length) this.speed = 0;
            this.$refs.p.playbackRate = this.speeds[this.speed];
            window.$toast.success('Speed: ' + this.speeds[this.speed])
        },
        seek(e) {
            const req = e.offsetX * 100 / this.$refs.seekbar.clientWidth;
            this.$refs.p.currentTime = req * this.full / 100;
        },
        timeOffset(sec) { this.$refs.p.currentTime += sec; },
        stopNow() {
            let p = this.$refs.p;
            p.pause();
            p.currentTime = 0;
        },
        playPause() {
            this.refreshKey++;
            let p = this.$refs.p;
            if (this.isPlay) p.pause();
            else p.play();
        },
        updatePlayer() {
            try {
                let p = this.$refs.p;
                if (!isNaN(p.duration)) {
                    this.fullTime = this.toHHMMSS(p.duration);
                    this.currentTime = this.toHHMMSS(p.currentTime);
                    this.full = p.duration;
                    this.current = p.currentTime;

                }
                this.isPlay = !p.paused;
            } catch {}
        },
        toHHMMSS(secs) {
            let sec_num = parseInt(secs, 10);
            let hours = Math.floor(sec_num / 3600);
            let minutes = Math.floor(sec_num / 60) % 60;
            let seconds = sec_num % 60;

            return [hours, minutes, seconds]
                .map(v => v < 10 ? "0" + v : v)
                .filter((v, i) => v !== "00" || i > 0)
                .join(":");
        },
    }
}
</script>

<style scoped>
.mp4-player {
    padding: 1rem;
    border-radius: var(--xshop-border-radius);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

.video {
    width: 100%;
    height: auto; /* Maintain aspect ratio */
    border-radius: var(--xshop-border-radius);
}

.seek-container {
    padding: .75rem 0;
    width: 100%;
}

.seekbar {
    height: 4px;
    background: silver;
    border-radius: var(--xshop-border-radius);
    cursor: pointer;
    overflow: hidden;
    transition: 0.3s;
}

.seekbar:hover {
    height: 10px;
}

.progress-seek {
    height: 100%;
    background: var(--xshop-primary);
    width: 0%;
    transition: width 0.3s linear;
}

.player-buttons {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-evenly;
    width: 100%;
    gap: 8px;
}

.play-pause {
    background: var(--xshop-primary);
    color: var(--xshop-diff);
    font-size: 45px;
    width: 75px;
    height: 75px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    border: none;
}

.p-btn {
    border: none;
    background: var(--xshop-secondary);
    color: var(--xshop-diff2);
    font-size: 30px;
    width: 50px;
    height: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
}

/* Mobile responsive */
@media (max-width: 450px) {
    .player-buttons {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
    }
}

.start{
    position: absolute;
    top: calc(50% - 40px);
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 75px;
    background: #ffffff66;
    width: 100px;
    height: 100px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 7px;
}
.poster{
    max-width: 100%;
}
</style>
