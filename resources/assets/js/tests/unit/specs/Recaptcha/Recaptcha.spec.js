import Recaptcha from '../../../../plugins/Recaptcha';
import recaptcha from '../../../../plugins/Recaptcha/wrapper';
import { destroyVM } from '../Utils';
import { mount } from 'avoriaz';

const WIDGET_ID = 'widgetId';
const SITE_KEY = '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI';

const createWrapper = propsData => {
    return mount(Recaptcha, {propsData})
};

describe('Recaptcha', () => {

    let wrapper;
    afterEach(() => {
        destroyVM(wrapper);
    });

    wrapper = createWrapper({sitekey: SITE_KEY});

    it('Should render ReCAPTCHA', () => {
        //spyOn(recaptcha, 'checkRecaptchaLoad');
        //expect(recaptcha.checkRecaptchaLoad).toHaveBeenCalled();
        //expect(recaptcha.render).toBe(wrapper.instance().$refs.container);
        //expect(recaptcha.render.calls[0][1]).toMatchSnapshot('ReCAPTCHA options');
    });

    it('Emit events', () => {
        const spyVerify = jasmine.createSpy('spy');
        const spyExpired = jasmine.createSpy('spy');
        const verify = (args) => { spyVerify(args) };
        const expired = (args) => { spyExpired(args) };

        wrapper.instance().$on('verify', verify);
        wrapper.instance().$on('expired', expired);

        expect(spyVerify).not.toHaveBeenCalled();
        expect(spyExpired).not.toHaveBeenCalled();

        wrapper.instance().emitVerify();
        expect(spyVerify).toHaveBeenCalled();

        wrapper.instance().emitExpired();
        expect(spyExpired).toHaveBeenCalled();

        wrapper.instance().$off();
    });

    it('Can reset/execute', () => {
        spyOn(recaptcha, 'reset');
        expect(recaptcha.reset).not.toHaveBeenCalled();
        wrapper.instance().reset();
        expect(recaptcha.reset).toHaveBeenCalledWith(WIDGET_ID);

        spyOn(recaptcha, 'execute');
        expect(recaptcha.execute).not.toHaveBeenCalled();
        wrapper.instance().execute();
        expect(recaptcha.execute).toHaveBeenCalledWith(WIDGET_ID);
    });
});