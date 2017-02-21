<template lang="html">
    <nav :class="classObject"
         :style="width:width + 'px'"
         v-show="show">
        <slot></slot>
    </nav>
</template>

<script type="text/babel">
    import { getScrollBarWidth } from '../utils'

    export default {
        props: {
            show: {
                type: Boolean,
                required: true,
            },
            placement: {
                type: String,
                default: 'right'
            },
            header: {
                type: String
            },
            width: {
                type: Number,
                default: 320
            }
        },
        watch: {
            show (val) {
                const body = document.body
                const scrollBarWidth = getScrollBarWidth()
                if (val) {
                    if (!this._backdrop) {
                        this._backdrop = document.createElement('div')
                    }
                    this._backdrop.className = 'aside-backdrop'
                    body.appendChild(this._backdrop)
                    body.classList.add('modal-open')
                    if (scrollBarWidth !== 0) {
                        body.style.paddingRight = scrollBarWidth + 'px'
                    }
                    // request property that requires layout to force a layout
                    var x = this._backdrop.clientHeight
                    this._backdrop.classList.add('in')
                    $(this._backdrop).on('click', () => this.close())
                } else {
                    $(this._backdrop).on('transitionend', () => {
                        $(this._backdrop).off()
                        try {
                            body.classList.remove('modal-open')
                            body.style.paddingRight = '0'
                            body.removeChild(this._backdrop)
                            this._backdrop = null
                        } catch (e) {}
                    })
                    this._backdrop.className = 'aside-backdrop'
                }
            }
        },
        computed: {
            classObject () {
                return {
                    'be-left-sidebar': this.placement === 'left',
                    'be-right-sidebar': this.placement === 'right',
                }
            }
        },
        methods: {
            close () {
                this.show = false
            }
        }
    }
</script>