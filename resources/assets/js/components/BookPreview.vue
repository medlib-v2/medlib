<template lang="html">
  <div class="preview-book-wrapper" @click.stop>
    <message-error v-if="error"></message-error>
    <div class="preview-loading" v-if="loading"><div></div></div>
    <transition :name="transition">
      <div class="book-wrapper">
        <div class="panel-menu" v-show="show">
          <div class="row">
            <div class="col-md-3"><menu-select></menu-select></div>
            <div class="col-md-9">
              <div class="menu-controls">
                <button class="menu-btn btn-zoom-in" @click.prevent="zoomIn">Zoom In</button>
                <button class="menu-btn btn-zoom-out" @click.prevent="zoomOut">Zoom Out</button>
                <button class="menu-btn btn-zoom-prev" @click.prevent="previousPage">previous page</button>
                <button class="menu-btn btn-zoom-next" @click.prevent="nextPage">previous next</button>
              </div>
            </div>
          </div>
        </div>
          <div id="wrapper-book" class="book"></div>
      </div>
    </transition>
  </div>
</template>

<script type="text/babel">
import MenuSelect from './MenuSelect.vue'
import MessageError from './MessageError.vue'
import store from '../stores/PreviewStore'

export default {
  name: 'book-preview',
  components: { MenuSelect, MessageError },
  props: {
    /**
    * ISBN pf the book to show
    * @type isbn: string
    */
    isbn: {type: String, required: true, observer: 'isbnChange'},
    pageId: {
      type: String,
      default: null,
      validator: (value) => {
        return value.length === 3
      }
    }
  },
  data () {
    return {
      loading: true,
      viewer: null,
      direction: 'top',
      state: store.state,
      show: false,
      error: false
    }
  },
  watch: {
    isbn: (val, oldVal) => { console.log('isbn: %s, old: %s', val, oldVal) }
  },
  mounted () {
    let self = this
    this.viewer = new this.manger.DefaultViewer(document.getElementById('wrapper'), { 'showLinkChrome': 'false' })
    this.viewer.load('ISBN:' + this.isbn, this.bookNotFound, this.bookFound)
    window.addEventListener('resize', this.onIronResize)
  },
  methods: {
    bookNotFound () {
      let $bookPreview = $('.book-preview')
      this.loading = false
      this.error = true
      if ($bookPreview !== null) {
        $bookPreview.remove($('#wrapper'))
      }
    },
    bookFound () {
      let $wrapperDiv = document.querySelector('#wrapper > div')
      this.loading = false
      this.show = true
      if (this.pageId) this.viewer.goToPageId(this.pageId)
      else this.pageId = this.viewer.getPageId()

      if ($wrapperDiv == null ) {
        this.viewer = new this.manger.DefaultViewer(document.getElementById('wrapper'), { 'showLinkChrome': 'false' })
        this.viewer.load('ISBN:' + this.isbn, this.bookNotFound, this.bookFound)
      }
      else {
        /** document.querySelector('#wrapper > div > div').removeChild(document.querySelector('#wrapper > div > div > div:nth-child(2)')) **/
        /**
        * Removing google tool bar
        * $('#wrapper div').remove('#wrapper div div:nth-child(2)')
        **/

        $('#wrapper > div > div:nth-child(2)').each(function() {
          console.log('tool bar')
          this.remove()
        })

        $('#wrapper div div > div:nth-child(1)').on('scroll', throttle(() => {
          if (this.state.pageId !== null) {
            this.state.pageId[this.state.index] = this.viewer.getPageId()
          }
        }, 600))
      }
      function throttle (callback, delay) {
        let timer, last
        return function () {
          let args = arguments,
          context = this,
          now = +new Date()
          if (last && now < last + delay) {
            clearTimeout(timer)
            timer = setTimeout(function() {
              callback.apply(context, args)
              last = now
            }, delay)
          } else {
            callback.apply(context, args)
            last = now
          }
        }
      }
      this.onIronResize()
    },
    isbnChange (o, n) {
      if (o !== n && typeof this.viewer !== 'undefined') {
        this.viewer.load('ISBN:' + n, (s) => { console.log(s) })
      }
    },
    onIronResize () {
      if (typeof this.viewer !== 'undefined') {
        this.viewer.resize()
      }
    },
    pageIdChange (o, n) {
      if (o !== n && typeof this.viewer !== 'undefined') {
        this.viewer.goToPageId(n)
        this.set('pageId', this.viewer.getPageNumber())
      }
    },
    nextPage () {
      /** Go to the next page in the book. */
      if (typeof this.viewer !== 'undefined') {
        return this.viewer.nextPage()
      }
    },
    /** Go to the previous page in the book. */
    previousPage () {
      if (typeof this.viewer !== 'undefined') {
        return this.viewer.previousPage()
      }
    },
    /** Zoom into the viewer. */
    zoomIn () {
      if (typeof this.viewer !== 'undefined') {
        return this.viewer.zoomIn()
      }
    },
    /** Zoom out of the viewer. */
    zoomOut () {
      if (typeof this.viewer !== 'undefined') {
        return this.viewer.zoomOut()
      }
    },
    /** Goto a given page number. */
    gotoPageNumber (n) {
      if (typeof this.viewer !== 'undefined') {
        return this.viewer.goToPage(n)
      }
    },
    /** Goto a page using its identifier. */
    gotoPageId (n) {
      if (typeof this.viewer !== 'undefined') {
        return this.viewer.goToPage(n)
      }
    }
  },
  computed: {
    manger () {
      if (store.manger !== null) {
        return store.manger
      }
    },
    transition () {
      return 'book-' + this.direction
    }
  },
  destroyed () {
    window.removeEventListener('resize', this.onIronResize)
  }
}
</script>
