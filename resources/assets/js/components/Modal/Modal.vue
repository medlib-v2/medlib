<template lang="html">
    <div>
        <transition-group enter-class="hidden"
                          enter-to-class="show"
                          enter-active-class=""
                          leave-class="show"
                          leave-active-class=""
                          leave-to-class="hidden"
                          v-on:after-enter="afterEnter"
        >
            <div key="modal"
                 :id="id"
                 role="dialog"
                 v-if="visible"
                 :class="['modal',{fade :fade}, {zoom :zoom}]"
                 @click="onClickOut($event)"
                 @keydown.esc.stop="$emit('hide::modal')">

                <div :class="['modal-dialog','modal-'+size]" role="document">
                    <div class="modal-content">

                        <div class="modal-header" v-if="showHeader">
                            <slot name="modal-header">
                                <h5 class="modal-title">
                                    <slot name="modal-title">{{title}}</slot>
                                </h5>
                                <button type="button" class="close modal-close" aria-label="Close" @click="hide">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </slot>
                        </div>
                        <div class="modal-header" v-else>
                            <slot name="modal-header">
                                <button type="button" class="close modal-close" aria-label="Close" @click="hide">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </slot>
                        </div>

                        <div class="modal-body">
                            <slot></slot>
                        </div>

                        <div class="modal-footer" v-if="showFooter">
                            <slot name="modal-footer">
                                <b-button variant="secondary" @click="hide(false)">{{closeTitle}}</b-button>
                                <b-button variant="primary" @click="hide(true)">{{okTitle}}</b-button>
                            </slot>
                        </div>

                        <div class="modal-footer" v-else>
                            <slot name="modal-footer"></slot>
                        </div>

                    </div>
                </div>
            </div>

            <div key="modal-backdrop"
                 :class="['modal-backdrop',{fade: fade}]"
                 v-if="visible"
            ></div>
        </transition-group>
    </div>
</template>

<script type="text/babel">
    const Html = document.documentElement;
    export default {
        name: 'modal',
        data() {
            return {
                visible: false
            };
        },
        computed: {
            body() {
                if (typeof document !== 'undefined') {
                    return document.querySelector('body');
                }
            }
        },
        props: {
            id: {
                type: String,
                default: null
            },
            title: {
                type: String,
                default: ''
            },
            size: {
                type: String,
                default: 'md'
            },
            fade: {
                type: Boolean,
                default: true
            },
            zoom: {
                type: Boolean,
                default: false
            },
            closeTitle: {
                type: String,
                default: 'Close'
            },
            okTitle: {
                type: String,
                default: 'OK'
            },
            closeOnBackdrop: {
                type: Boolean,
                default: true
            },
            showHeader: {
                type: Boolean,
                default: false
            },
            showFooter: {
                type: Boolean,
                default: true
            }
        },
        methods: {
            show() {
                if (this.visible) {
                    return;
                }
                this.visible = true;
                this.$root.$emit('shown::modal', this.id);
                Html.classList.add('be-modal-open');
                this.body.classList.add('modal-open');
                this.$emit('shown');
            },
            hide(isOK) {
                if (!this.visible) {
                    return;
                }
                this.visible = false;
                this.$root.$emit('hidden::modal', this.id);
                Html.classList.remove('be-modal-open');
                this.body.classList.remove('modal-open');
                this.$emit('hidden', isOK);
                if (isOK === true) {
                    this.$emit('ok');
                } else if (isOK === false) {
                    this.$emit('cancel');
                }
            },
            onClickOut(e) {
                // If backdrop clicked, hide modal
                if (this.closeOnBackdrop && e.target.id && e.target.id === this.id) {
                    this.hide();
                }
            },
            pressedButton(e) {
                // If not visible don't do anything
                if (!this.visible) {
                    return;
                }
                // Support for esc key press
                const key = e.which || e.keyCode;
                if (key === 27) { // 27 is esc
                    this.hide();
                }
            },
            afterEnter(el) {
                // Add show class to keep el showed just after transition is ended,
                // Because transition removes all used classes
                //el.classList.add('show');
                el.classList.add('in');
            }
        },
        created() {
            this.$root.$on('show::modal', id => {
                if (id === this.id) {
                    this.show();
                }
            });
            this.$root.$on('hide::modal', id => {
                if (id === this.id) {
                    this.hide();
                }
            });
        },
        mounted() {
            if (typeof document !== 'undefined') {
                document.addEventListener('keydown', this.pressedButton);
            }
        },
        destroyed() {
            if (typeof document !== 'undefined') {
                document.removeEventListener('keydown', this.pressedButton);
            }
        }
    };
</script>