export default {
    methods: {
        /**
         * reCAPTCHA response token
         * @param response
         **/
        onVerify (response) {
            console.log('Verify: ' + response)
        },

        /**
         * reCAPTCHA token expired
         **/
        onExpired () {
            console.log('Expired')
        },

        /**
         * Direct call reset method
         **/
        resetRecaptcha () {
            this.$refs.recaptcha.reset()
        }
    }
}