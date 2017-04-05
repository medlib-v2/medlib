import cookie from '../../../../services/cookie';

describe('JsCookie', () => {
    describe('::parse', () => {
        it('should argument validation', () => {
            expect(() => { cookie.parse() }).toThrow(new TypeError('argument str must be a string'));
            expect(() => { cookie.parse(null, 42) }).toThrow(new TypeError('argument str must be a string'));
        });

        it('should parse the basic', () => {
            expect(cookie.parse('foo=bar')).toEqual({ foo: 'bar' });
            expect(cookie.parse('foo=123')).toEqual({ foo: '123' });
        });

        it('should ignore spaces', () => {
            expect(cookie.parse('FOO    = bar;   baz  =   raz')).toEqual({ FOO: 'bar', baz: 'raz' });
        });

        it('should escaping', () => {
            expect(cookie.parse('foo="bar=123456789&name=Magic+Mouse"')).toEqual({ foo: 'bar=123456789&name=Magic+Mouse' });
        });

        it('should not parse if we ask not to', () => {
            expect(cookie.parse('email=%20%22%2c%3b%2f')).toEqual({ email: ' ",;/' });
        });
    });
});