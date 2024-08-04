<template>
    <div class="mp3-player">
        <audio ref="p" :src="link" class="player"></audio>
        <div class="seek-container">
            <div ref="seekbar" class="seekbar" @click="seek">
                <div class="progress-seek" :style="progressPercent"></div>
            </div>
        </div>
        <div class="player-buttons">

            <div>
                {{ currentTime }}
            </div>
            <button type="button" class="rw p-btn" @click="timeOffset(-10)">
                <i class="ri-rewind-line"></i>
            </button>
            <button type="button" class="sp p-btn" @click="speedChange">
                <i class="ri-speed-up-line"></i>
            </button>
            <button type="button" class="play-pause" @click="playPause">
                <i class="ri-play-line" v-if="!isPlay"></i>
                <i class="ri-pause-line" v-if="isPlay"></i>
            </button>
            <button type="button" class="stop p-btn" @click="stopNow" >
                <i class="ri-stop-line"></i>
            </button>
            <button type="button" class="sp p-btn" @click="timeOffset(10)">
                <i class="ri-speed-line"></i>
            </button>
            <div>
                {{ fullTime }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "mp3-player",
    components: {},
    data: () => {
        return {
            link: '',
            currentTime: '00:00',
            fullTime: '00:00',
            isPlay: false,
            full: 0,
            current: 0,
            speed: 2,
            speeds: [
                .5,
                .75,
                1.0,
                1.25,
                1.5,
                1.75,
                2.0,
            ]
        }
    },
    props: {
        asset: {
            required: true
        }
    },
    mounted() {
        window.addEventListener('load',()=>{
        setTimeout(() => {
            this.link = this.asset;
        }, 500);
        setInterval(() => {
            this.updatePlayer();
        }, 300);
        });
    },
    computed: {

        progressPercent() {
            if (this.full != 0) {
                return 'width:' + (this.current * 100) / this.full + '%;';
            }
            return 'width: 0%;';
        }
    },
    methods: {
        speedChange() {
            this.speed++;
            if (this.speed  === this.speeds.length){
                this.speed = 0;
            }
            this.$refs.p.playbackRate = this.speeds[this.speed];
            window.$toast.success('Speed: '+this.speeds[this.speed])
        },
        seek(e) {
            const req = e.offsetX * 100 / this.$refs.seekbar.clientWidth;
            this.$refs.p.currentTime = req * this.full / 100;
        },
        timeOffset(sec) {
            this.$refs.p.currentTime += sec;
        },
        stopNow() {
            let p = this.$refs.p;
            p.pause();
            p.currentTime = 0;

        },
        playPause() {
            let p = this.$refs.p;
            if (this.isPlay) {
                p.pause();
            } else {
                p.play();
            }
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

                this.isPlay = ! p.paused;

            } catch {
            }
        },
        toHHMMSS(secs) {
            let sec_num = parseInt(secs, 10)
            let hours = Math.floor(sec_num / 3600)
            let minutes = Math.floor(sec_num / 60) % 60
            let seconds = sec_num % 60

            return [hours, minutes, seconds]
                .map(v => v < 10 ? "0" + v : v)
                .filter((v, i) => v !== "00" || i > 0)
                .join(":")
        }
    }
}
</script>

<style scoped>
.mp3-player {
    border: 1px solid var(--xshop-primary);
    padding: 1rem;
    border-radius: var(--xshop-border-radius);
}


.seekbar {
    height: 4px;
    margin-bottom: 16px;
    background: silver;
    overflow: hidden;
    transition: 300ms;
    border-radius: var(--xshop-border-radius);
}

.seek-container {
    padding: .75rem 0;
    height: 50px;

    &:hover {
        .seekbar {
            height: 20px;
            margin-bottom: 0;
        }
    }
}

.progress-seek {
    height: 20px;
    width: 10%;
    background: silver;
    transition: 295ms;
    transition-timing-function: linear;
    background: var(--xshop-primary);

}

.player-buttons {
    display: flex;
    align-items: center;
    justify-content: space-evenly;
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
    border-width: 0;

    i.ri-play-line {
        width: 40px;
    }
}

.p-btn {
    border-width: 0;
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

</style>
