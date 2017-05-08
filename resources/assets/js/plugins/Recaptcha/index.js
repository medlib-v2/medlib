import Recaptcha from './wrapper'

export default {
    name: 'Recaptcha',
    props: {
        sitekey: {
            type: String,
            required: true
        },
        theme: {
            type: String
        },
        badge: {
            type: String
        },
        type: {
            type: String
        },
        size: {
            type: String
        },
        tabindex: {
            type: String
        }
    },
    data () {
        return {
            widgetId: null
        }
    },
    mounted () {
        Recaptcha.checkRecaptchaLoad();
        const opts = {
            ...this.$props,
            callback: this.emitVerify,
            'expired-callback': this.emitExpired
        };
        const container = this.$slots.default ? this.$refs.container.children[0] : this.$refs.container;
        Recaptcha.render(container, opts, (id) => {
            this.widgetId = id;
            this.$emit('render', id)
        })
    },
    methods: {
        reset () {
            Recaptcha.reset(this.widgetId);
        },
        execute () {
            Recaptcha.execute(this.widgetId);
        },
        emitVerify (response) {
            this.$emit('input', response);
            this.$emit('verify', response);
        },
        emitExpired () {
            this.$emit('expired');
        }
    },
    render (h) {
        return h('div', {ref: 'container'}, this.$slots.default)
    }
}