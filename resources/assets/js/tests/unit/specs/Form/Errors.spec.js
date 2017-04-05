import Errors from '../../../../components/Form/Errors'

let errors;

describe('Form', () => {
    describe('::Errors', () => {

        beforeEach(() => {
            errors = new Errors()
        });

        it('should set errors', () => {
            expect(errors.errors).toEqual({});

            errors.set({ 'username': ['Value is required'] });
            expect(errors.errors).toEqual({ 'username': ['Value is required'] });
        });

        it('should get all errors', () => {
            const allErrors = { 'username': ['Value is required'] };
            errors.set(allErrors);

            expect(allErrors).toEqual(errors.all())
        });

        it('should determine if there is an error for a field', () => {
            errors.set({ 'username': ['Value is required'] });

            expect(errors.has('username')).toBeTruthy();
        });

        it('should determine if there are any errors for the given fields', () => {
            errors.set({ 'username': ['Value is required'], 'password': ['Value is required'], 'email': ['Value is required'] });

            expect(errors.hasAny('username', 'email')).toBeTruthy();
        });

        it('should determine if there are any errors', () => {
            errors.set({ 'username': ['Value is required'] });

            expect(errors.any()).toBeTruthy();
        });

        it('should get the error message for a field', () => {
            errors.set({ 'username': ['Value is required'] });

            expect(errors.get('username')).toBe('Value is required');
            expect(errors.get('password')).toBe(undefined);
        });

        it('should get the error message for the given fields', () => {
            errors.set({ 'username': ['Username is required'], 'password': ['Password is required'], 'email': ['Email is required'] });

            expect(errors.only('username', 'email')).toEqual(['Username is required', 'Email is required']);
        });

        it('should get all the errors in a flat array', () => {
            errors.set({ 'username': ['Username is required'], 'email': ['Email is required', 'Email is not valid'] });

            expect(errors.flatten()).toEqual(['Username is required', 'Email is required', 'Email is not valid']);
        });

        it('should clear one error field', () => {
            errors.set({ 'username': ['Value is required'], 'password': ['Value is required'] });
            errors.clear('username');

            expect(errors.has('username')).toBeFalsy();
            expect(errors.has('password')).toBeTruthy();
        });

        it('should clear all the error fields', () => {
            errors.set({ 'username': ['Value is required'], 'password': ['Value is required'] });
            errors.clear();

            expect(errors.any()).toBeFalsy();
        });

    });
});