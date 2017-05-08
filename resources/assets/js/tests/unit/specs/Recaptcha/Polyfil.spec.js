import Promise from '../../../../plugins/Recaptcha/polyfil'

describe('Promise', () => {
    it('Return Promise object', () => {
        const deferred = Promise();
        expect(deferred).toBeLessThanOrEqual({
            promise: {
                then: Function
            },
            resolve: Function,
            resolved: Function
        })
    });

    describe('::resolve', () => {
        it('Resolve with given value', () => {
            const deferred = Promise();
            const value = 42;
            spyOn(deferred, 'resolve');
            deferred.resolve(value);
            expect(deferred.resolve).toHaveBeenCalledWith(value);
        });

        it('Wont resolve twice', () => {
            const deferred = Promise();
            const fn = jasmine.createSpy('spy');
            const value = 42;
            const value2 = 24;

            spyOn(deferred, 'resolve');

            deferred.promise.then(fn);

            deferred.resolve(value);
            deferred.resolve(value2);
            expect(deferred.resolve).toHaveBeenCalledWith(value)
        });
    });

    describe('::resolved', () => {
        it('Return state', () => {
            const deferred = Promise();
            expect(deferred.resolved()).toBe(false);
            deferred.resolve();
            expect(deferred.resolved()).toBe(true);
        })
    })
});