import { deepCopy, hasFile, toFormData } from '../../../../utils'

describe('Form', () => {
    describe('::Util', () => {
        it('should deep copy a plain object', () => {
            const obj = { a: { b: { c: 1 }}};
            const copy = deepCopy(obj);
            obj.a.b.c = 2;

            expect(copy.a.b.c).toEqual(1);
            expect(copy).toEqual({ a: { b: { c: 1 }}});
        });

        it('should determine if the object contains any files', () => {
            expect(hasFile({ username: 'foo' })).toBeFalsy();
            expect(hasFile({ photo: new Blob([new Uint8Array(10)], { type: 'image/png' }) })).toBeTruthy();
        });

        it('should convert a plain object to a FormData object', () => {
            const obj = {
                username: 'foo',
                photo: new Blob([new Uint8Array(10)], { type: 'image/png' }),
                items: [{ name: 'item 1' }, { name: 'item 2' }]
            };
            const data = toFormData(obj);

            expect(data instanceof FormData).toBeTruthy();

            expect(data.has('photo')).toBeTruthy();
            expect(data.has('items')).toBeTruthy();
            expect(data.has('username')).toBeTruthy();
        });
    });
});