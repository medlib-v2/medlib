<template lang="html">
    <div v-if="!image">
        <div class="dropzone-area" @dragenter="hovering = true" @dragleave="hovering = false" :class="{'dropzone-hover': hovering}">
            <div class="dropzone-text">
                <span class="dropzone-title">Drop image here or click to select</span>
                <span class="dropzone-info" v-if="info">{{ info }}</span>
            </div>
            <input type="file" class="form-control" name="image" id="image" accept="image/*" @change="onFileChange">
        </div>
    </div>
    <div class="dropzone-preview" v-else>
        <img :src="image" class="dropzone-image"/>
        <div class="dropzone-close modal-close" @click="removeImage">
            <span></span><span></span>
        </div>
    </div>
</template>

<script type="text/babel">
    import Store from '../stores'
    import each from 'lodash/each'
    function noop() {}

    export default {
        name: 'upload-image',
        props: {
          info: {
            type: String,
            required: true
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
                let files = e.target.files || e.dataTransfer.files
                if (!files.length) return
                each(files, (file, index) => {
                    this.uploadFiles.push(file);
                    this.createImage(files[index])
                })
                this.onChange(this.uploadFiles);
            },
            createImage(file) {
                let image = new Image()
                let reader = new FileReader()
                let vm = this
                reader.onload = (e) => {
                    vm.image = e.target.result
                    vm.hovering = false
                }
                reader.readAsDataURL(file)
            },
            removeImage(e) {
                this.image = ''
                let fileList = this.uploadFiles
                fileList.splice(fileList.indexOf(file), 1)
                this.onRemove(file)
            }
        }
    }
</script>
