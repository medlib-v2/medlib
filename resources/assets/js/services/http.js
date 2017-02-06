import Vue from 'vue';

/**
 * Responsible for all HTTP requests.
 */
export const http = {
    /**
     *
     * @param method
     * @param url
     * @param data
     * @param successCallback
     * @param errorCallback
     */
    request (method, url, data, successCallback = null, errorCallback = null) {
        method = method.toLowerCase();

        Vue.http[method]({
            url,
            data,
        }).then(successCallback).catch(errorCallback)
    },
    /**
     *
     * @param url
     * @param successCallback
     * @param errorCallback
     * @returns {*}
     */
    get (url, successCallback = null, errorCallback = null) {
        return Vue.http.get(url).then(successCallback).catch(errorCallback);
    },
    /**
     *
     * @param url
     * @param data
     * @param successCallback
     * @param errorCallback
     * @returns {*}
     */
    post (url, data, successCallback = null, errorCallback = null) {
        return Vue.http.post(url, data).then(successCallback, errorCallback);
    },
    /**
     *
     * @param url
     * @param data
     * @param successCallback
     * @param errorCallback
     * @returns {*}
     */
    put (url, data, successCallback = null, errorCallback = null) {
        return Vue.http.put(url, data).then(successCallback, errorCallback);
    },
    /**
     *
     * @param url
     * @param data
     * @param successCallback
     * @param errorCallback
     * @returns {*}
     */
    delete (url, data = {}, successCallback = null, errorCallback = null) {
        return Vue.http.delete(url, data).then(successCallback, errorCallback);
    }
};