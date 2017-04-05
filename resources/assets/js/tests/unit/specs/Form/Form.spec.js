import Form from '../../../../components/Form/Form';
import Errors from '../../../../components/Form/Errors';

let form;

describe('Form', () => {
    describe('::Form', () => {

        beforeEach(() => {
            form = new Form({
                username: 'foo',
                password: 'bar'
            });
        });
        afterEach(() => { form = null });

        it('it instantiates the form properties', () => {
            expect(form.busy).toBeFalsy();
            expect(form.successful).toBeFalsy();
            expect(form.successful).toBeFalsy();
            expect(form.errors instanceof Errors).toBeTruthy();
            expect(form.originalData).toEqual({ username: 'foo', password: 'bar' });
        });

        it('it exposes the passed form field values as properties', () => {
            expect(form.username).toBe('foo');
            expect(form.password).toBe('bar');
        });

        it('it can get the form data', () => {
            expect(form.data()).toEqual({ username: 'foo', password: 'bar' });
        });

        it('it will start processing the form', () => {
            form.startProcessing();

            expect(form.busy).toBeTruthy();
            expect(form.successful).toBeFalsy();
            expect(form.errors.any()).toBeFalsy();
        });

        it('it will finish processing the form', () => {
            form.finishProcessing();

            expect(form.busy).toBeFalsy();
            expect(form.successful).toBeTruthy();
        });

        it('it can clear the form errors', () => {
            form.clear();

            expect(form.errors.any()).toBeFalsy();
            expect(form.successful).toBeFalsy();
        });

        it('it can reset the form values', () => {
            form.username = 'bar';
            form.password = 'foo';
            form.reset();

            expect(form.username).toBe('foo');
            expect(form.password).toBe('bar');
        });

        describe('::Service', () => {
            it('it will submit the form successfully', () => {
                form.post('/auth/login').then(() => {
                    expect(form.busy).toBeFalsy();
                    expect(form.successful).toBeTruthy();
                    expect(form.errors.any()).toBeFalsy();
                })
            });

            it('it will convert the data object to FormData if it contains files', () => {
                form.photo = new Blob([new Uint8Array(10)], { type: 'image/png', lastModified: new Date(0) });

                form.put('/user/photo').then(config => {
                    expect(config.data instanceof FormData).toBeTruthy();
                    expect(config.data.has('photo')).toBeTruthy();
                    expect(config.data.has('username')).toBeTruthy();
                })
            });

            it('it will set errors from the server', () => {
                form.post('/auth/error')
                    .then(() => {})
                    .catch(() => {})
                    .then(() => {
                        expect(form.errors.any()).toBeTruthy();
                        expect(form.busy).toBeFalsy();
                        expect(form.successful).toBeFalsy();
                    })
            });
        });

        describe('::Response object', () => {

            it('it can extract the errors from the response object', () => {
                let response = {};

                expect(form.extractErrors(response)).toEqual({ error: 'Something went wrong. Please try again.' });

                response = { body: { errors: { 'username': ['Value is required'] }}};
                expect(form.extractErrors(response)).toEqual({ 'username': ['Value is required'] });

                response = { body: { message: 'Value is required' }};
                expect(form.extractErrors(response)).toEqual({ 'error': 'Value is required' });

                response = { body: { 'username': ['Value is required'] }};
                expectl(form.extractErrors(response)).toEqual({ 'username': ['Value is required'] });
            });
        });
    });
});