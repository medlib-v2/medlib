import { Recaptcha } from '../../../../plugins/Recaptcha/wrapper'

const WIDGET_ID = 'widgetId';
const recaptchaMock = {
    render: () => WIDGET_ID,
    reset: () => {},
    execute: () => {}
};

let instance;


describe('Recaptcha', () => {

    const JasmineHelpers = () => {

        let promise = {};

        promise.promise = new Promise((resolve, reject) => {
            promise.resolve = resolve;
            promise.reject = reject;
        });

        const deferredSuccess = (args) => {
            promise.resolve(args);
            return promise.promise;
        };

        const deferredFailure = (args) => {
            promise.reject(args);
            return promise.promise;
        };

        return {
            deferredSuccess: deferredSuccess,
            deferredFailure: deferredFailure
        };
    };

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
                    /**
                    const spy = (Instance, method = null) => {
                        if (method) {
                            Instance.call(method);
                        }
                        return Instance
                    };
                    spy(instance);
                    // Since it return thenable, not Promise. Here must wrap it as Promise
                    const promise = Promise.resolve(instance.getRecaptcha()).then(spy);
                    expect(spy).not.toHaveBeenCalled();

                    spy(instance, 'setRecaptcha');

                    instance.setRecaptcha(instance);
                    return promise.then(() => {
                        expect(spy).toHaveBeenCalled();
                    });
                    **/

                    let jasmineHelpers = new JasmineHelpers();

                    spyOn(instance, "getRecaptcha").and.callFake(() => {
                        return jasmineHelpers.deferredSuccess();
                    });
                    instance.getRecaptcha().then((recaptcha)=> {
                        expect(recaptcha).toBe('object');
                    });
                    //expect(spy).not.toHaveBeenCalled();
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