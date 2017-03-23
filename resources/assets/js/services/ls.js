import localStore from 'local-storage'

export const ls = {
    storagePrefix: '_auth.',
    redirectType: 'router',
    authPath: '/login',
    userData: undefined,
    getStorageKey(part) { return this.storagePrefix + part },
    get (key, defaultVal = null) { return localStore(key) || defaultVal },
    set (key, val) { return localStore(key, val) },
    remove (key) { return localStore.remove(key) }
};