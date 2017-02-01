<template>
    <div class="center-form">
        <form role="form" :method="method" :action="action" accept-charset="UTF-8" enctype="multipart/form-data" class="mt" @submit.prevent="submit">
            <div class="form-group mb-0">
                <textarea rows="3" :placeholder="placeholder" v-model="content" cols="50" class="form-control"></textarea>
            </div>
            <div class="share">
                <div class="image" :class="image_hide">
                    <upload-image info="Minimum width 700px, will be cropped to 16:9"></upload-image>
                </div>
                <div class="video" :class="video_hide">
                    <input type="text" class="form-control" placeholder="Youtube or Vimeo video URL" id="videoUrl" name="videoUrl">
                </div>
                <div class="place" :class="place_hide">
                    <google-autocomplete type="input" placeholder="type your address"></google-autocomplete>
                    <span class="help is-danger" v-if="sent && isNotValid()">Select a valid address!</span>
                </div>
            </div>
            <div class="btn-toolbar share-components">
                <div class="clearfix">
                    <div class="btn-group pull-left">
                        <a href="#" class="btn btn-sm btn-gray" @click.prevent="status"><i class="fa fa-file fa-lg"></i></a>
                        <a href="#" class="btn btn-sm btn-gray" @click.prevent="photos"><i class="fa fa-camera fa-lg"></i></a>
                        <a href="#" class="btn btn-sm btn-gray" @click.prevent="video"><i class="fa fa-film fa-lg"></i></a>
                        <a href="#" class="btn btn-sm btn-gray" @click.prevent="place"><i class="fa fa-map-marker fa-lg"></i></a>
                    </div>
                    <div class="btn-group pull-right">
                        <button type="submit" class="btn btn-success pull-right" :disabled="not_working">Publier</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script type="text/babel">
import GoogleAutocomplete from './GoogleAutocomplete.vue'
import UploadImage from './UploadImage.vue'

import { mapGetters } from 'vuex'
//import store from '../stores'
//import $ from '../utils'

export default {
    name: 'form-input',
    components: { GoogleAutocomplete, UploadImage },
    props: {
        method: {
            type: String,
            default: 'POST'
        },
        action: {
            type: String,
            required: true
        },
        placeholder: {
            type: String,
            required: true,
            default: ''
        }
    },
    data() {
        return {
            content: '',
            address: {},
            image: {},
            not_working: true,
            image_class: true,
            video_class: true,
            place_class: true
        }
    },
    computed: {
        image_hide(){
            return {
                'hide': this.image_class == true
            }
        },
        video_hide() {
            return {
                'hide': this.video_class == true
            }
        },
        place_hide() {
            return {
                'hide': this.place_class == true
            }
        },
        ...mapGetters([
            'shared_address',
            'shared_image'
        ])
    },
    methods: {
        status() {
            this.image_class = true
            this.video_class = true
            this.place_class = true
        },
        photos() {
            this.image_class = false
            this.video_class = true
            this.place_class = true
        },
        video() {
            this.image_class = true
            this.video_class = false
            this.place_class = true
        },
        place() {
            this.image_class = true
            this.video_class = true
            this.place_class = false
        },
        submit() {
            let data = new FormData()
            data.append('body', this.content)

            if (this.image) {
                data.append('image', this.image)
            }

            if (this.address) {
                data.append('location', JSON.stringify(this.address))
            }

            this.$http.post(this.action, data)
                .then((resp) => {
                    this.content = ''
                    this.address = {}
                    this.image = {}
                    console.log(resp, 'Medlib %o', Medlib)
                })
        },
        isValid () {
			return Object.keys(this.address).length > 0
		},
		isNotValid () {
			return ! this.isValid()
		}
    },
    watch: {
        content() {
            if(this.content.length > 0)
                this.not_working = false
            else
                this.not_working = true
        },
        shared_address() {
			this.address = this.shared_address
		},
		shared_image() {
			this.image = this.shared_address
		}
    }
}
</script>