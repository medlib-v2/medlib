import * as JwtToken from '../../../utils/jwtToken'

describe('JwtToken Helper', () => {
    it('to decode a valid token', () => {
        const token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOjEsIm5hbWUiOiJKYW5lIERvZSJ9.F0aM7iXee139nQE4FD5Lw5l89NxkKuFJ_2iU09MNYUk";
        const decoded = JwtToken.decode(token);

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

        expect(JwtToken.getDeadline(token).getTime()).toBe(2524608000000);
        expect(JwtToken.getDeadline(missing)).toBe(null)
    });

    it('to correctly test if a token has expired', () => {
        // Expired in 2000
        const expired = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiIxIiwiZXhwIjo5NDY2ODQ4MDB9.4DPaehBA1-6ll6E6xiSpGjqv9P9X1yOCj1-I6tyyuv8";

        // Expires in 2050
        const unexpired = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiIxIiwiZXhwIjoyNTI0NjA4MDAwfQ.egn6G7vB80nH3NwlgUZ9bwUAlLnkEV8kR8PN0edKCJI";

        // Missing exp property
        const missing = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiIxIn0.ClQFOEhtNQtmx71eSzmUhW1lfs9LHGCsT-Y4v8LHE5k";

        expect(JwtToken.isExpired(expired)).toBe(true);
        expect(JwtToken.isExpired(unexpired)).toBe(false);
        expect(JwtToken.isExpired(missing)).toBe(false)
    });
});