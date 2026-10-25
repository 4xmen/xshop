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

                    <div :class="canPremium?'col-md-3 pt-1':'col-md-4 pt-1'">
                        {{ attach.file.split('attachments/').join('') }}
                    </div>
                    <!-- WIP translate -->
                    <div class="col-md-1 pt-1 position-relative" v-if="canPremium" title="toggle permium"
                    >
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" :id="'p'+attach.id"
                                   @change="changePremium(attach)" :checked="attach.is_premium">
                            <label class="form-check-label" :for="'p'+attach.id">
                                <i :class="'ri-shield-keyhole-line ' + ( attach.is_premium?'lime': '')"></i>
                            </label>
                        </div>
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
        canPremium: {
            default: false,
            type: Boolean,
        },
        toggleUrl: {
            type: String,
            default: 'http://127.0.0.1:8000/dashboard/attachments/permium/toggle/',
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
                    if (document.querySelector('#attach-number') != null) {
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
        async changePremium(attach, i) {
            try {
                let resp = await axios(this.toggleUrl + attach.slug);
                if (resp.data.OK) {

                    try {
                        this.attachments[i].is_premium = !attach.is_premium;
                        this.$forceUpdate();
                    } catch (e) {
                        console.log(e.message);
                    }

                    $toast.success(resp.data.message);
                } else {

                    $toast.success("Error !");
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
                    if (document.querySelector('#attach-number') != null) {
                        document.querySelector('#attach-number').innerText = this.attachments.length;
                    }
                    this.title = '';
                }
                // Optionally, add the new attachment to the attachments array
            } catch (error) {
                console.error(error);

                // Default fallback message
                let messages = ['Upload failed!'];

                if (error.response) {
                    // Laravel validation errors (422)
                    if (error.response.data?.errors) {
                        const errors = error.response.data.errors;

                        // Flatten all error messages into a single array
                        messages = Object.values(errors).flat();
                    }

                    // General API message
                    else if (error.response.data?.message) {
                        messages = [error.response.data.message];
                    }

                    // HTTP status fallback
                    else {
                        messages = [`Error ${error.response.status}`];
                    }
                } else if (error.request) {
                    messages = ['No response from server'];
                } else {
                    messages = [error.message];
                }

                // Show each error separately
                messages.forEach(msg => {
                    this.$toast.error(msg, {duration: 5000});
                });
            } finally {
                this.isShowProgress = false;
            }
        }
    }
}
</script>
<style scoped>
#new-attach {
    position: absolute;
    inset-block-start: 0;
    inset-inline-end: calc(var(--spacing-xl) + var(--control-height-sm) + var(--spacing-xs));
    display: grid;
    place-items: center;
    inline-size: var(--control-height-sm);
    block-size: var(--control-height-sm);
    border: 1px solid var(--color-border);
    border-block-start: 0;
    border-radius: 0 0 var(--radius-md) var(--radius-md);
    background-color: var(--color-success-subtle);
    color: var(--color-success-text);
    font-size: 1.25rem;
    cursor: pointer;
}

#new-attach:hover {
    border-color: var(--color-success-text);
}

#new-attach:focus-visible {
    outline: 2px solid var(--color-focus-ring);
    outline-offset: 2px;
}

#progress {
    position: relative;
    isolation: isolate;
    margin-block: var(--spacing-xl);
    padding-block: var(--spacing-xs);
    padding-inline: var(--spacing-md);
    overflow: hidden;
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    background-color: var(--color-field);
    color: var(--color-text);
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-medium);
    text-align: center;
}

#percent {
    position: absolute;
    inset-block: 0;
    inset-inline-start: 0;
    z-index: -1;
    border-inline-end: 2px solid var(--color-success-dot);
    background-color: var(--color-success-subtle);
}

#fast-attaching .badge.bg-success {
    background-color: var(--color-success-subtle) !important;
    color: var(--color-success-text);
}

.ri-shield-keyhole-line {
    position: absolute;
    inset-block-start: -3px;
    display: inline-block;
    color: var(--color-text-muted);
    font-size: 1.5rem;
}

.lime {
    color: var(--color-success-text);
}
</style>
