import cookie from '../../../services/cookie';

describe('cookie', function() {

    describe('parse', function() {
        it('should argument validation', () => {
            expect(() => { cookie.parse.bind() }).be.throwError();
            expect(() => { cookie.parse.bind(null, 42) }).be.throwError();
        });

        it('should parse the basic', function() {
            expect(cookie.parse('foo=bar')).toBe({ foo: 'bar' });
            expect(cookie.parse('foo=123')).toBe({ foo: '123' });
        });

        it('should ignore spaces', function() {
            expect(cookie.parse('FOO    = bar;   baz  =   raz')).toBe({ FOO: 'bar', baz: 'raz' });
        });

        it('should escaping', function() {
            expect(cookie.parse('foo="bar=123456789&name=Magic+Mouse"')).toBe({ foo: 'bar=123456789&name=Magic+Mouse' });
        });

        it('should not parse if we ask not to', function() {
            expect(typeof cookie.parse('email=%20%22%2c%3b%2f')).toBe({ email: ' ",;/' });
        });
    });
});