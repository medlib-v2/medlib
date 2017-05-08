<template lang="html">
    <transition-group enter-class="hidden"
                      enter-to-class="show"
                      enter-active-class=""
                      leave-class="show"
                      leave-active-class=""
                      leave-to-class="hidden"
                      v-on:after-enter="afterEnter"
                      v-on:before-leave="beforeLeave"
    >
        <div key="modal"
             :id="id"
             role="dialog"
             v-if="visible"
             :class="['modal',{fade :fade}, {zoom :zoom}, className]"
             @click="onClickOut($event)"
             @keydown.esc.stop="$emit('hide::modal')">

            <div :class="['modal-dialog','modal-'+size]" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <slot name="modalHeader">
                            <h5 class="modal-title" v-if="showHeader">
                                <slot name="modalTitle">{{title}}</slot>
                            </h5>
                            <button type="button" class="close modal-close" aria-label="Close" @click="hide">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </slot>
                    </div>

                    <div class="modal-body">
                        <slot></slot>
                    </div>

                    <div class="modal-footer">
                        <slot name="modalFooter">
                            <b-button :variant="cancelVariant" @click="hide(false)" v-if="showFooter">{{closeTitle}}</b-button>
                            <b-button :variant="okVariant" @click="hide(true)" v-if="showFooter">{{okTitle}}</b-button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>

        <div key="modal-backdrop"
             :class="['modal-backdrop', {fade: fade}]"
             v-if="visible"
        ></div>
    </transition-group>
</template>

<script type="text/babel">
    const Html = document.documentElement;
    export default {
        name: 'Modal',
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
            },
            className: {
                type: String
            },
            okVariant: {
                type: String,
                default: 'primary'
            },
            cancelVariant: {
                type: String,
                default: 'secondary'
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
                el.classList.add('in');
            },
            beforeLeave (el) {
                el.classList.add('out');
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