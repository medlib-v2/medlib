import localStorage from 'local-storage'
import { ls } from '../../../services'

describe('localStorage', () => {
    afterEach(() => {
        localStorage.remove('_auth.token');
        localStorage.remove('_auth.user');
    });

    describe('#get', () => {
        it('to return the correct storage key', () => {
            expect(ls.getStorageKey('token')).toBe('_auth.token');
        });

        it('correctly gets an existing item from local storage', () => {
            localStorage('foo', 'bar');
            expect(ls.get('foo')).toEqual('bar');
        });

        it('correctly returns the default value for a non exising item', () => {
            expect(ls.get('baz', 'qux')).toEqual('qux');
        });

        it('to store and retrieve an auth token', () => {
            localStorage('kebab-news-thing');
            expect(ls.get('kebab-news-thing')).toBe('kebab-news-thing');
        });

        it('to store and retrieve user data', () => {
            const dataIn = {name: 'Jane Doe', age: 20};
            localStorage('data', dataIn);
            const dataOut = ls.get('data');
            expect(dataOut.name).toBeDefined();
            expect(dataOut.name).toEqual('Jane Doe');
            expect(dataOut.age).toBeDefined();
            expect(dataOut.age).toEqual(20);
        });
    })

    describe('#set', () => {
        it('correctly sets an item into local storage', () => {
            ls.set('foo', 'bar');
            expect(localStorage('foo')).toEqual('bar');
        })
    });


    describe('#remove', () => {
        it('correctly removes an item from local storage', () => {
            localStorage('foo', 'bar');
            ls.remove('foo');
            let result = localStorage('foo') === null;

            expect(result).toBeTruthy();
        })
    })
});