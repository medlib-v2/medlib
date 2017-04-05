import Promise from './polyfil'

export class Recaptcha {
    /**
     * @constructor Recaptcha
     */
    constructor() {
        this.deferred = Promise();
        this.recaptcha = null;
    }

    /**
     *
     * @param recaptcha
     */
    setRecaptcha (recaptcha) {
        this.recaptcha = recaptcha;
        this.deferred.resolve(recaptcha);
    }

    /**
     *
     * @returns {Promise}
     */
    getRecaptcha () {
        if (this.recaptcha !== null) {
            return this.deferred.resolve(this.recaptcha);
        }
        return this.deferred.promise
    }

    /**
     *
     * @param ele
     * @param options
     * @param cb
     */
    render (ele, options, cb) {
        return this.getRecaptcha().then((recaptcha) => {
            let opts = Object.assign({}, options);
            return cb(recaptcha.render(ele, opts));
            //return recaptcha.render(ele, opts);
        })
    }

    /**
     *
     * @param widgetId
     */
    reset (widgetId) {
        /**
        let args = [];
        if (arguments.length > 0) {
            if (typeof widgetId === 'undefined') {
                return false;
            } else {
                args = [widgetId];
            }
        }
         this.assertRecaptchaLoad();
         this.getRecaptcha().then((recaptcha) => recaptcha.reset.apply(null, widgetId));
        **/

        if (typeof widgetId === 'undefined') {
            return false;
        }

        this.assertRecaptchaLoad();
        this.getRecaptcha().then((recaptcha) => recaptcha.reset(widgetId));
    }

    /**
     *
     * @param widgetId
     */
    execute (widgetId) {
        if (typeof widgetId === 'undefined') {
            return false;
        }

        this.assertRecaptchaLoad();
        return this.getRecaptcha().then((recaptcha) => recaptcha.execute(widgetId));
    }

    /**
     *
     */
    checkRecaptchaLoad () {
        if (window.hasOwnProperty('grecaptcha')) {
            this.setRecaptcha(window.grecaptcha)
        }
    }

    /**
     * @throws Error
     */
    assertRecaptchaLoad () {
        if (this.recaptcha === null) {
            throw new Error('ReCAPTCHA has not been loaded');
        }
    }
}

const recaptcha = new Recaptcha();

if (typeof window !== 'undefined') {
    window.vueRecaptchaApiLoaded = () => {
        recaptcha.setRecaptcha(window.grecaptcha)
    }
}

export default recaptcha