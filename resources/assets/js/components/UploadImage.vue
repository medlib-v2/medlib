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
    import _ from 'lodash'

    export default {
        name: 'upload-image',
        props: ['info'],
        data() {
            return {
                image: '',
                hovering: false
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
                var files = e.target.files || e.dataTransfer.files
                if (!files.length) return
                _.each(files, function(v, k) {
                    /**
                    * this.createImage(files[k])
                    * data.append('avatars['+k+']', v)
                    **/
                    console.log(v, k, 'image')
                })
                /** Store.commit('SET_IMAGE', files) **/
                this.createImage(files[0])
            },
            createImage(file) {
                var image = new Image()
                var reader = new FileReader()
                var vm = this
                reader.onload = (e) => {
                    vm.image = e.target.result
                    vm.hovering = false
                };
                reader.readAsDataURL(file)
            },
            removeImage(e) {
                this.image = ''
            }
        }
    }
</script>