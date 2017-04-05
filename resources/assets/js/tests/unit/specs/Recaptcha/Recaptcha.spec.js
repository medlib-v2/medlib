import Vue from 'vue'
import Recaptcha from '../../../../plugins/Recaptcha'
import recaptcha from '../../../../plugins/Recaptcha/wrapper'

const WIDGET_ID = 'widgetId';
const SITE_KEY = 'sitekey';

describe('Recaptcha', () => {

    const Constructor = Vue.extend(Recaptcha);
    const wrapper = new Constructor({
        props: {
            sitekey: SITE_KEY
        }
    }).$mount();


    /**
    it('Should render ReCAPTCHA', () => {
        expect(recaptcha.checkRecaptchaLoad).toBeCalled();
        expect(recaptcha.render.mock.calls[0][0]).toBe(wrapper.$refs.container);
        expect(recaptcha.render.mock.calls[0][1]).toMatchSnapshot('ReCAPTCHA options');
    });
     **/

    it('Emit events', () => {
        const verify = () => {};
        const expired = () => {};
        wrapper.$on('verify', verify);
        wrapper.$on('expired', expired);

        expect(verify).not.toBeCalled();
        wrapper.emitVerify();
        expect(verify).toBeCalled();

        expect(expired).not.toBeCalled();
        wrapper.emitExpired();
        expect(expired).toBeCalled();

        wrapper.$off();
    });

    it('Can reset/execute', () => {
        expect(recaptcha.reset).not.toBeCalled();
        wrapper.reset();
        expect(recaptcha.reset).toBeCalledWith(WIDGET_ID);

        expect(recaptcha.execute).not.toBeCalled();
        wrapper.execute();
        expect(recaptcha.execute).toBeCalledWith(WIDGET_ID);
    });
});