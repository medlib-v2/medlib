<template>
  <transition name="preview-book-fade">
    <div class="preview-book" v-if="isbn" @click="close">
      <transition :name="transition">
        <book-preview :isbn="isbn" :key="isbn" :page-id="pageId" :style="style" class="light-box"></book-preview>
      </transition>
      <div class="btn-preview-close" @click.stop="close"></div>
    </div>
  </transition>
</template>

<script>
import BookPreview from './components/BookPreview.vue'
import store from './stores/PreviewStore'

/**
* style: {
        position: 'fixed',
        width: '600px',
        height: '700px',
        top: '50%',
        left: '50%',
        'margin-top': '-20px',
        'margin-left': '-20px'
      }
**/
export default {
    name: 'boxPreview',
    components: { BookPreview },
    data () {
        return {
            state: store.state,
            direction: 'top'
        }
    },
    mounted () {
        window.addEventListener('resize', this.resizeListener)
    },
    methods: {
        close () {
            store.close();
        },
        resizeListener () {
            this.style = this.setStyle(700, 800);
        },
        setStyle (width, height) {
            if (width > window.innerWidth || height > window.innerHeight) {
               let ratio = width / height
               let windowRatio = window.innerWidth / window.innerHeight
               if (ratio > windowRatio) {
                    width = window.innerWidth
                    height = width / ratio
               } else {
                    width = window.innerHeight
                    height = width * ratio
               }
            }

            return {
                width: width + 'px',
                height: height + 'px',
                top: (window.innerHeight - height) * 0.5 + 'px',
                left: (window.innerWidth - width) * 0.5 + 'px'
            }
        }
    },
    computed: {
        isbn () {
            if (this.state.index !== false) {
                return this.state.books[this.state.index];
            }
        },
        pageId () {
            if (this.state.index !== false) {
                return this.state.pageId[this.state.index];
            }
        },
        manger () {
            if (store.manger !== false) {
                return store.manger;
            }
        },
        transition () {
            return 'preview-' + this.direction;
        },
        style () {
            return this.setStyle(600, 700);
        }
    },
    destroyed () {
        window.removeEventListener('resize', this.resizeListener)
    }
}
</script>
