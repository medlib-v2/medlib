<template lang="html">
    <div v-if="!image">
        <div class="dropzone-area" @dragenter="hovering = true" @dragleave="hovering = false"
             :class="{'dropzone-hover': hovering}">
            <div class="dropzone-text">
                <span class="dropzone-title">
                    <svg v-if="showIcon" width="37px" height="31px" viewBox="82 16 37 31" version="1.1"
                         xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <path class="dropzone-icon"
                              d="M100.642879,30.142874 C100.642879,30.5044816 100.361629,30.7857319 100.000021,30.7857319 C98.935288,30.7857319 98.0714477,31.6495722 98.0714477,32.7143056 C98.0714477,33.0759132 97.7901974,33.3571635 97.4285898,33.3571635 C97.0669822,33.3571635 96.7857319,33.0759132 96.7857319,32.7143056 C96.7857319,30.9464464 98.2321622,29.5000161 100.000021,29.5000161 C100.361629,29.5000161 100.642879,29.7812664 100.642879,30.142874 L100.642879,30.142874 Z M105.142885,32.7544843 C105.142885,29.9218916 102.832614,27.611621 100.000021,27.611621 C97.1674288,27.611621 94.8571582,29.9218916 94.8571582,32.7544843 C94.8571582,35.5870769 97.1674288,37.8973475 100.000021,37.8973475 C102.832614,37.8973475 105.142885,35.5870769 105.142885,32.7544843 L105.142885,32.7544843 Z M84.5714316,44.285748 L84.5714316,41.7143164 L115.428611,41.7143164 L115.428611,44.285748 L84.5714316,44.285748 Z M107.714316,32.7544843 C107.714316,37.0134179 104.258955,40.4687792 100.000021,40.4687792 C95.7410878,40.4687792 92.2857265,37.0134179 92.2857265,32.7544843 C92.2857265,28.4955506 95.7410878,25.0401893 100.000021,25.0401893 C104.258955,25.0401893 107.714316,28.4955506 107.714316,32.7544843 L107.714316,32.7544843 Z M87.1428633,19.8571475 L87.1428633,17.2857158 L94.8571582,17.2857158 L94.8571582,19.8571475 L87.1428633,19.8571475 Z M84.5714316,23.7142949 L84.5714316,21.1428633 L97.5089471,21.1428633 L98.7946629,18.5714316 L115.428611,18.5714316 L115.428611,21.3437564 L115.428611,23.7142949 L84.5714316,23.7142949 Z M118.000043,18.5714316 C118.000043,17.1450907 116.854952,16 115.428611,16 L84.5714316,16 C83.1450907,16 82,17.1450907 82,18.5714316 L82,44.285748 C82,45.712089 83.1450907,46.8571796 84.5714316,46.8571796 L115.428611,46.8571796 C116.854952,46.8571796 118.000043,45.712089 118.000043,44.285748 L118.000043,18.5714316 Z"
                              id="icon-camera" stroke="none" fill="#E0E7EE" fill-rule="evenodd"></path>
                    </svg>
                    <span>Drop image here or click to select</span>
                </span>
                <span class="dropzone-info" v-if="info">{{ info }}</span>
            </div>
            <input type="file" class="form-control" name="image" id="image" accept="image/*" @change="onFileChange">
        </div>
    </div>
    <div class="dropzone-preview" v-else>
        <img :src="image" class="dropzone-image"/>
        <div class="dropzone-close modal-close" @click="removeImage">
            <svg width="25px" height="25px" viewBox="1143 30 51 51" version="1.1" xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink">
                <g class="btn-close" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                   transform="translate(1144.000000, 31.000000)">
                    <circle id="Oval-1" stroke="#979797" fill="#D8D8D8" cx="24.5" cy="24.5" r="24.5"></circle>
                    <path d="M20.9324444,22.228 C21.0977037,22.3951429 21.3149259,22.4782857 21.5321481,22.4782857 C21.7493704,22.4782857 21.9665926,22.3951429 22.1318519,22.228 C22.4632222,21.8945714 22.4632222,21.3537143 22.1318519,21.0202857 L15.3468519,14.1862857 C15.0154815,13.8528571 14.4788148,13.8528571 14.1474444,14.1862857 C13.8160741,14.5197143 13.8160741,15.0605714 14.1474444,15.394 L20.9324444,22.228 L20.9324444,22.228 Z"
                          id="Shape" fill="#979797"></path>
                    <path d="M26.1244815,25.0411429 L35.7035556,15.394 C36.0349259,15.0605714 36.0349259,14.5197143 35.7035556,14.1862857 C35.3721852,13.8528571 34.8355185,13.7054286 34.5041481,14.0397143 L24.3262222,24.1428571 L24.0740741,24.1428571 L24.0740741,24.4385714 L14.0222222,34.6882857 C13.6908519,35.0217143 13.7538889,35.5625714 14.0844074,35.896 C14.2496667,36.0631429 14.4984074,36.1462857 14.7156296,36.1462857 C14.9328519,36.1462857 15.1654074,36.0631429 15.3306667,35.896 L24.9174074,26.2497143 L34.4998889,35.8968571 C34.6651481,36.064 34.8849259,36.1471429 35.1012963,36.1471429 C35.3176667,36.1471429 35.5365926,36.064 35.7018519,35.8968571 C36.0332222,35.5634286 36.0340741,35.0225714 35.7027037,34.6891429 L26.1244815,25.0411429 L26.1244815,25.0411429 Z"
                          id="Shape" fill="#979797"></path>
                </g>
            </svg>
        </div>
    </div>
</template>

<script type="text/babel">
    import Store from '../stores'
    import each from 'lodash/each'

    function noop() {
        //
    }

    export default {
        name: 'upload-image',
        props: {
            info: {
                type: String,
                required: true
            },
            showIcon: {
                type: Boolean,
                default: false
            },
            onRemove: {
                type: Function,
                default: noop
            },
            onChange: {
                type: Function,
                default: noop
            },
            onError: {
                type: Function,
                default: noop
            },
            fileList: {
                type: Array,
                default() {
                    return []
                }
            }
        },
        data() {
            return {
                image: '',
                hovering: false,
                uploadFiles: []
            }
        },
        watch: {
            /**
             * Store the image retrieved in the vuex store.
             *
             * @return {Void}
             */
            image() {
                Store.commit('SET_IMAGE', this.image)
            }
        },
        methods: {
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length) return;
                each(files, (file, index) => {
                    this.uploadFiles.push(file);
                    this.createImage(files[index])
                });

                this.$emit('input', this.uploadFiles[0]);
                this.onChange(this.uploadFiles);
            },
            createImage(file) {
                let image = new Image();
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                    vm.hovering = false
                };
                reader.readAsDataURL(file)
            },
            removeImage(e) {
                this.image = '';
                this.$emit('input', this.image);
                let fileList = this.uploadFiles;
                fileList.splice(fileList.indexOf(file), 1);
                this.onRemove(file)
            }
        }
    }
</script>
