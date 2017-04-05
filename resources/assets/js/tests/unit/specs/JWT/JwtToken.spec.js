import localStorage from 'local-storage'
import { jwtToken } from '../../../../utils/jwtToken'

describe('jwtToken Helper', () => {

    afterEach(() => {
        localStorage.remove('jwt-token');
        localStorage.remove('kebab-news-thing');
    });

    describe('::store', () => {
        it('should store and retrieve an auth token', () => {
            jwtToken.setToken('kebab-news-thing');

            expect(jwtToken.getToken()).toBe('kebab-news-thing');
        });
        it('should store and retrieve user data', () => {

            const dataIn = {name: 'Jane Doe', age: 20};
            jwtToken.setUserData(dataIn);

            const dataOut = jwtToken.getUserData();

            expect(dataOut.name).toBeDefined();
            expect(dataOut.name).toEqual('Jane Doe');
            expect(dataOut.age).toBeDefined();
            expect(dataOut.age).toEqual(20);
        });
    });

    describe('::detect', () => {
        it('should detect has a token stored', () => {
            expect(jwtToken.hasToken()).toBe(false);

            jwtToken.setToken('kebab-news-thing');

            expect(jwtToken.hasToken()).toBe(true);
        });
    });

    describe('::decode', () => {
        const token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJmb28iOiJiYXIiLCJleHAiOjEzOTMyODY4OTMsImlhdCI6MTM5MzI2ODg5M30.4-iaDojEVl0pJQMjrbM1EzUIfAZgsbK_kgnVyVxFSVo';

        it('should fail to construct without a clientID', () => {
            const decoded = jwtToken.decode(token);
            expect(decoded.exp).toBe(1393286893);
            expect(decoded.iat).toBe(1393268893);
            expect(decoded.foo).toBe('bar');
        });

        it('should return header information', () => {
            const decoded = jwtToken.decode(token, { complete: true });
            expect(decoded.header.typ).toBe('JWT');
            expect(decoded.header.alg).toBe('HS256');
            expect(decoded.payload.foo).toBe('bar');
        });

        it('should work with utf8 tokens', () => {
            const utf8_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiSm9zw6kiLCJpYXQiOjE0MjU2NDQ5NjZ9.1CfFtdGUPs6q8kT3OGQSVlhEMdbuX0HfNSqum0023a0";
            const decoded = jwtToken.decode(utf8_token);
            expect(decoded.name).toBe('José');
        });

        it('should null on nonstring', () => {
            const bad_token = null;
            const decoded = jwtToken.decode(bad_token);
            expect(decoded).toBeNull();
        });

        it('should null on string that is not a token', () => {
            const bad_token = "fubar";
            const decoded = jwtToken.decode(bad_token);
            expect(decoded).toBeNull();
        });

        it('to decode a valid token', () => {
            const token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOjEsIm5hbWUiOiJKYW5lIERvZSJ9.F0aM7iXee139nQE4FD5Lw5l89NxkKuFJ_2iU09MNYUk";
            const decoded = jwtToken.decode(token);

            expect(decoded.aud).toBeDefined();
            expect(decoded.aud).toBe(1);
            expect(decoded.name).toBeDefined();
            expect(decoded.name).toBe('Jane Doe')
        });

        it('to decode and convert the expiry time', () => {
            // Exp: 2524608000
            const token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiIxIiwiZXhwIjoyNTI0NjA4MDAwfQ.egn6G7vB80nH3NwlgUZ9bwUAlLnkEV8kR8PN0edKCJI";

            // Missing exp property
            const missing = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiIxIn0.ClQFOEhtNQtmx71eSzmUhW1lfs9LHGCsT-Y4v8LHE5k";

            expect(jwtToken.getDeadline(token).getTime()).toBe(2524608000000);
            expect(jwtToken.getDeadline(missing)).toBe(null)
        });
    });

    describe('::token::expired', () => {
        it('to correctly test if a token has expired', () => {
            // Expired in 2000
            const expired = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiIxIiwiZXhwIjo5NDY2ODQ4MDB9.4DPaehBA1-6ll6E6xiSpGjqv9P9X1yOCj1-I6tyyuv8";

            // Expires in 2050
            const unexpired = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiIxIiwiZXhwIjoyNTI0NjA4MDAwfQ.egn6G7vB80nH3NwlgUZ9bwUAlLnkEV8kR8PN0edKCJI";

            // Missing exp property
            const missing = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiIxIn0.ClQFOEhtNQtmx71eSzmUhW1lfs9LHGCsT-Y4v8LHE5k";

            expect(jwtToken.isExpired(expired)).toBe(true);
            expect(jwtToken.isExpired(unexpired)).toBe(false);
            expect(jwtToken.isExpired(missing)).toBe(false)
        });
    });
});