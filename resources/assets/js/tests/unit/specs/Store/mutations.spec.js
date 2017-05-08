import mutations from '../../../../stores/modules/users/mutations';
import * as types from '../../../../stores/modules/users/types';

describe('users reducer', () => {
    it('should handle SET_USER', () => {
        const setUsers = mutations[types.SET_USER];
        const state = {users: []};
        const user = {id: 1, username: 'username', completed: true},
            user2 = {id: 2, username: 'me', completed: false},
            user3 = {id: 3, username: 'user3', completed: true};

        setUsers(state, user);
        expect(state.users).toEqual([{id: 1, username: 'username', completed: true}]);

        state.users = [user];
        setUsers(state, user2);
        expect(state.users).toEqual([user, user2]);

        state.users = [user, user2];

        setUsers(state, user3);
        expect(state.users).toEqual([user, user2, user3]);
    });

    /**
    it('should handle DELETE_TODO', () => {
        const deleteTodo = mutations[types.DELETE_TODO];
        const state = {users: [
            {
                text: 'Run the tests',
                completed: false,
                id: 1
            }, {
                text: 'Use Redux',
                completed: false,
                id: 0
            }
        ]};
        deleteTodo(state, 1);
        expect(state.users).toEqual([
            {
                text: 'Use Redux',
                completed: false,
                id: 0
            }
        ]);
    });

    it('should handle EDIT_TODO', () => {
        const editTodo = mutations[types.EDIT_TODO];
        const state = {users: [
            {
                text: 'Run the tests',
                completed: false,
                id: 1
            }, {
                text: 'Use Redux',
                completed: false,
                id: 0
            }
        ]};
        editTodo(state, 1, 'Fix the tests');
        expect(state.users).toEqual([
            {
                text: 'Fix the tests',
                completed: false,
                id: 1
            }, {
                text: 'Use Redux',
                completed: false,
                id: 0
            }
        ]);
    });

    it('should handle COMPLETE_TODO', () => {
        const completeTodo = mutations[types.COMPLETE_TODO];
        const state = {users: [
            {
                text: 'Run the tests',
                completed: false,
                id: 1
            }, {
                text: 'Use Redux',
                completed: false,
                id: 0
            }
        ]};
        completeTodo(state, 1);
        expect(state.users).toEqual([
            {
                text: 'Run the tests',
                completed: true,
                id: 1
            }, {
                text: 'Use Redux',
                completed: false,
                id: 0
            }
        ]);
    });

    it('should handle COMPLETE_ALL', () => {
        const completeAll = mutations[types.COMPLETE_ALL];
        const state = {users: [
            {
                text: 'Run the tests',
                completed: true,
                id: 1
            }, {
                text: 'Use Redux',
                completed: false,
                id: 0
            }
        ]};
        completeAll(state);
        expect(state.users).toEqual([
            {
                text: 'Run the tests',
                completed: true,
                id: 1
            }, {
                text: 'Use Redux',
                completed: true,
                id: 0
            }
        ]);

        // Unmark if all users are currently completed
        completeAll(state);
        expect(state.users).toEqual([
            {
                text: 'Run the tests',
                completed: false,
                id: 1
            }, {
                text: 'Use Redux',
                completed: false,
                id: 0
            }
        ]);
    });

    it('should handle CLEAR_COMPLETED', () => {
        const clearCompleted = mutations[types.CLEAR_COMPLETED];
        const state = {users: [
            {
                text: 'Run the tests',
                completed: true,
                id: 1
            }, {
                text: 'Use Redux',
                completed: false,
                id: 0
            }
        ]};
        clearCompleted(state);
        expect(state.users).toEqual([
            {
                text: 'Use Redux',
                completed: false,
                id: 0
            }
        ]);
    });

    it('should not generate duplicate ids after CLEAR_COMPLETED', () => {
        const completeTodo = mutations[types.COMPLETE_TODO];
        const clearCompleted = mutations[types.CLEAR_COMPLETED];
        const setUsers = mutations[types.ADD_TODO];
        const state = {users: [
            {
                id: 0,
                completed: false,
                text: 'Use Redux'
            }, {
                id: 1,
                completed: false,
                text: 'Write tests'
            }
        ]};
        completeTodo(state, 0);
        clearCompleted(state);
        setUsers(state, 'Write more tests');
        expect(state.users).toEqual([
            {
                text: 'Write more tests',
                completed: false,
                id: 2
            }, {
                text: 'Write tests',
                completed: false,
                id: 1
            }
        ]);
    });
    **/
});