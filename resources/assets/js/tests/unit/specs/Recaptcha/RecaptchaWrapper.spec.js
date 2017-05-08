import { Recaptcha } from '../../../../plugins/Recaptcha/wrapper'

const WIDGET_ID = 'widgetId';
const recaptchaMock = {
    render: () => WIDGET_ID,
    reset: () => {},
    execute: () => {}
};

let instance;


describe('Recaptcha', () => {

    describe('::recaptcha', () => {

        beforeEach(() => {
            instance = new Recaptcha()
        });
        afterEach(() => {
            instance = null;
        });

        describe('::assertRecaptchaLoad', () => {
            describe('When ReCAPTCHA not loaded', () => {
                it('Throw error', () => {
                    expect(() => {
                        instance.assertRecaptchaLoad();
                    }).toThrow();
                });
            });
            describe('When ReCAPTCHA loaded', () => {
                it('Not throw error', () => {
                    instance.setRecaptcha(recaptchaMock);

                    expect(() => {
                        instance.assertRecaptchaLoad();
                    }).not.toThrow();
                });
            });
        });

        describe('::checkRecaptchaLoad', () => {
            describe('When Recaptcha not loaded', () => {
                it('Not load Recaptcha into it', () => {
                    instance.checkRecaptchaLoad();
                    expect(() => {
                        instance.assertRecaptchaLoad();
                    }).toThrow();
                });
            });

            describe('When Recaptcha loaded', () => {
                beforeEach(() => {
                    window.grecaptcha = recaptchaMock
                });
                afterEach(() => delete window.grecaptcha);

                it('Load Recaptcha', () => {
                    instance.checkRecaptchaLoad();

                    expect(() => {
                        instance.assertRecaptchaLoad()
                    }).not.toThrow();
                });
            });
        });

        describe('::getRecaptcha', () => {
            describe('Recaptcha not loaded', () => {
                it('Return defered object', () => {

                    const spy = jasmine.createSpy('then');
                    // Since it return thenable, not Promise. Here must wrap it as Promise
                    const promise = Promise.resolve(instance.getRecaptcha()).then(spy);
                    expect(spy).not.toHaveBeenCalled();
                    instance.setRecaptcha(recaptchaMock);
                    return promise.then(() => {
                        expect(spy).toHaveBeenCalled()
                    })
                });
            });
        });

        describe('::setRecaptcha', () => {

            it('Set recaptcha', () => {
                instance.setRecaptcha(recaptchaMock);
                return Promise.resolve(instance.getRecaptcha()).then((recap) => {
                    expect(recap).toBe(recaptchaMock);
                });
            });
        });

        describe('::render', () => {
            it('Render ReCAPTCHA', () => {
                const ele = document.createElement('div');
                const key = 'foo';

                instance.setRecaptcha(recaptchaMock);

                return instance.render(ele, key, (widgetId) => {
                    expect(recaptchaMock.render).toBeCalled();
                    expect(widgetId).toBe(WIDGET_ID);
                });
            });
        });

        describe('::reset', () => {
            describe('When pass widget id', () => {
                it('Reset ReCAPTCHA', () => {
                    spyOn(instance, "reset");
                    instance.reset(WIDGET_ID);
                    expect(instance.reset).toHaveBeenCalledWith(WIDGET_ID);
                });
            });

            describe('When not pass widget id', () => {
                it('Do nothing', () => {
                    spyOn(instance, "assertRecaptchaLoad");
                    instance.reset();
                    expect(instance.assertRecaptchaLoad).not.toHaveBeenCalled();
                });
            });

            beforeEach(() => {
                instance.setRecaptcha(recaptchaMock);
            });
        });

        describe('::execute', () => {
            beforeEach(() => {
                instance.setRecaptcha(recaptchaMock);
            });

            describe('When pass widget id', () => {
                it('Execute ReCAPTCHA', () => {
                    spyOn(instance, "execute");
                    instance.execute(WIDGET_ID);
                    expect(instance.execute).toHaveBeenCalledWith(WIDGET_ID);
                });
            });

            describe('When not pass widget id', () => {
                it('Do nothing', () => {
                    spyOn(instance, "assertRecaptchaLoad");
                    instance.execute();
                    expect(instance.assertRecaptchaLoad).not.toHaveBeenCalled();
                });
            });
        });
    });
});