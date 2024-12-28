<template>
    <div id="fast-attaching">

        <i class="ri-add-line" id="new-attach" data-bs-toggle="tooltip"
           data-bs-placement="top"
           data-bs-custom-class="custom-tooltip"
           data-bs-title="Add new attachment" @click="isShowNew = !isShowNew"></i>

        <div class="row mt-4" v-if="isShowNew">
            <div class="col-md">
                <input type="text" placeholder="Title" v-model="title" class="form-control">
            </div>
            <div class="col-md">
                <input type="file" class="form-control" id="upload-attachment-file" ref="fileInput">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="Upload"
                        @click="upload">
                    <i class="ri-upload-2-line"></i>
                </button>
            </div>
        </div>

        <div id="progress" v-if="isShowProgress">
            Uploading {{ title }}
            <div id="percent" :style="percentStyle"></div>
        </div>

        <ul class="list-group my-4">
            <li v-for="(attach,i) in attachments" :key="attach.id" class="list-group-item">
                <div class="row">
                    <div class="col-md-1 pt-1">
                        {{ i + 1 }}
                    </div>

                    <div class="col-md pt-1">
                        <span class="badge bg-success">
                            {{ attach.ext }}
                        </span>
                    </div>
                    <div class="col-md-4 pt-1">
                        <template v-if="xlang == null">
                            {{ attach.title }}
                        </template>
                        <template v-else>
                            {{ attach['title']?.[xlang] ?? attach.title }}
                        </template>
                    </div>

                    <div class="col-md-4 pt-1">
                        {{ attach.file }}
                    </div>
                    <div class="col-md-1">
                        <div class="btn btn-secondary btn-sm w-100" data-bs-toggle="tooltip"
                             data-bs-placement="top"
                             data-bs-custom-class="custom-tooltip"
                             data-bs-title="Detach"
                             @click="detach(attach.slug,i)"
                        >
                            <i class="ri-close-line"></i>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "fast-attaching",
    data() {
        return {
            title: '',
            isShowNew: false,
            isShowProgress: false,
            percent: 0,
        }
    },
    props: {
        attachments: {
            type: Array,
            default: () => [],
        },
        xlang: {
            default: null
        },
        uploadUrl: {
            type: String,
            default: 'http://127.0.0.1:8000/dashboard/attachments/attaching',
        },
        detachUrl: {
            type: String,
            default: 'http://127.0.0.1:8000/dashboard/attachments/attaching',
        },
        model: {
            type: String,
            default: 'App\\Models\\Post'
        },
        id: {
            type: Number,
            default: '1',
        },
    },
    computed: {
        percentStyle() {
            return 'width:' + this.percent + '%;';
        }
    },
    methods: {
        async detach(slug, index) {
            if (!confirm(window.TR.deleteConfirm)) {
                return false;
            }
            try {
                const response = await axios.get(this.detachUrl + slug);
                if (response.data.OK) {
                    $toast.success(response.data.message);
                    this.attachments.splice(index, 1);
                    if (document.querySelector('#attach-number') != null){
                        document.querySelector('#attach-number').innerText = this.attachments.length;
                    }
                    this.$forceUpdate();
                } else {
                    $toast.error("Detach problem!");
                }
            } catch (e) {
                $toast.error(e.message);
            }
        },
        async upload() {
            console.log('upload start');
            if (this.title.length < 2) {
                this.$toast.error('Title is incorrect');
                return false;
            }

            const fileInput = this.$refs.fileInput;
            if (fileInput.files.length === 0) {
                this.$toast.error('File is incorrect');
                return false;
            }

            this.isShowNew = false;
            this.isShowProgress = true;
            this.percent = 0; // Reset the percent

            const formData = new FormData();
            formData.append('title', this.title);
            formData.append('attachable_id', this.id);
            formData.append('attachable_type', this.model);
            formData.append('file', fileInput.files[0]); // Assuming only one file is selected

            try {
                const response = await axios.post(this.uploadUrl, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: progressEvent => {
                        if (progressEvent.lengthComputable) {
                            this.percent = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                        }
                    }
                });

                // Handle the response
                console.log(response.data);
                if (response.data.OK) {

                    this.$toast.success(response.data.message);
                    this.attachments.push(response.data.data); // Adjust based on your response
                    if (document.querySelector('#attach-number') != null){
                        document.querySelector('#attach-number').innerText = this.attachments.length;
                    }
                    this.title = '';
                }
                // Optionally, add the new attachment to the attachments array
            } catch (error) {
                console.error(error);
                this.$toast.error('Upload failed!');
            } finally {
                this.isShowProgress = false;
            }
        }
    }
}
</script>
<style scoped>
#fast-attaching {

}

#new-attach {
    position: absolute;
    inset-inline-end: 80px;
    top: 0;
    padding: 5px;
    background: rgba(8, 255, 0, 0.2);
    font-size: 30px;
    border-radius: 0 0 7px 7px;
    cursor: pointer;

    &:hover {
        background: rgba(8, 255, 0, 0.4);
    }
}

#progress {
    margin: 2rem 0;
    border: 1px solid #ffffff22;
    border-radius: 7px;
    overflow: hidden;
    text-align: center;
    position: relative;
}

#percent {
    background: rgba(8, 255, 0, 0.4);
    position: absolute;
    inset-inline-start: 0;
    top: 0;
    bottom: 0;
}
</style>
