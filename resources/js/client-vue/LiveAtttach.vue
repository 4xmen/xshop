<template>
    <div id="live-attach">
        <div class="card">
            <div class="card-header text-center">
                {{ attachment.title }}
            </div>
            <div class="card-body">
                <div v-if="attachment.ext == 'mp4' || attachment.ext == 'ogv' ">
                    <video-player :asset="attachment.url" :cover="cover"></video-player>
                </div>
                <div v-else-if="attachment.ext == 'mp3' || attachment.ext == 'ogg'">
                    <mp3player :asset="attachment.url"></mp3player>
                </div>
                <div
                    v-else-if="attachment.ext == 'jpg' || attachment.ext == 'jpeg' || attachment.ext == 'png' || attachment.ext == 'gif' || attachment.ext == 'svg'">
                    <img :src="attachment.url" :alt="attachment.title">
                </div>
                <div v-else>
                    <a :href="attachment.temp" class="btn btn-primary w-100">

                        <i class="ri-download-2-line"></i>
                        {{ attachment.title }}
                        ( {{ attachment.size }} ) [ {{attachment.ext}} ]
                    </a>
                </div>

            </div>
            <div class="card-footer">
                {{ attachment.subtitle }}
            </div>
        </div>
    </div>
</template>

<script>
import VideoPlayer from "./videoPlayer.vue";

export default {
    name: "live-attach",
    components: {VideoPlayer},
    data: () => {
        return {
            cover: '',
        }
    },
    props: {
        attachment: {
            default: {},
            required: true,
        }
    },
    mounted() {
        const cover = document.querySelector('meta[property="og:image"]');
        if (cover) {
            this.cover = cover.getAttribute('content');
        }
    },
    computed: {},
    methods: {}
}
</script>

<style scoped>
#live-attach {

}
</style>
