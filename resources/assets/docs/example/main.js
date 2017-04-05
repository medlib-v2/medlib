import Recaptcha from "../../js/plugins/Recaptcha"

/* global Vue: false, VueRecaptcha: false */
new Vue({ // eslint-disable-line no-new
    el: '#root',
    data: {
        sitekey: '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI'
    },
    components: {
        'recaptcha': Recaptcha
    },
    methods: {
        onSubmit: function () {
            this.$refs.invisibleRecaptcha.execute()
        },
        onVerify: function (response) {
            console.log('Verify: ' + response)
        },
        onExpired: function () {
            console.log('Expired')
        },
        resetRecaptcha () {
            this.$refs.recaptcha.reset() // Direct call reset method
        }
    }
})