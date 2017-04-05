import recaptcha from '../../../../plugins/Recaptcha/wrapper'

const WIDGET_ID = 'widgetId';
const recaptchaMock = {
    render: () => WIDGET_ID,
    reset: () => {},
    execute: () => {}
};

describe('Recaptcha', () => {
    describe('Loaded API Recaptcha', () => {
        beforeEach(() => {
            window.grecaptcha = recaptchaMock
        });
        afterEach(() => delete window.grecaptcha);

        it('Load grecaptcha', () => {
            window.vueRecaptchaApiLoaded();
            expect(() => recaptcha.assertRecaptchaLoad()).not.toThrow();
        });
    })
});