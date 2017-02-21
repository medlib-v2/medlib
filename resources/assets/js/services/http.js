import Vue from 'vue'

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
    method = method.toLowerCase()
    Vue.http[method]({
      url,
      data,
    }).then(successCallback).catch(errorCallback)
  },

  /**
   *
   * @param url
   * @param data
   * @param successCallback
   * @param errorCallback
   * @returns {*}
   */
  get (url, data = {}, successCallback = null, errorCallback = null) {
    return Vue.http.get(url, data).then(successCallback).catch(errorCallback)
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
    return Vue.http.post(url, data).then(successCallback).catch(errorCallback)
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
    return Vue.http.put(url, data).then(successCallback).catch(errorCallback)
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
     return Vue.http.delete(url, data).then(successCallback).catch(errorCallback)
   },

   /**
    *
    * @param url
    * @param data
    * @returns {*}
    */
   makeUrl (url, data) {
     //let link = this.data.serviceHost + url;
     let link = url;
        if (typeof data != "undefined" && data != "") {
            let paramArr = [];
            for (let attr in  data) {
                paramArr.push(attr + '=' +  data[attr]);
            }
            link += '?' + paramArr.join('&');
        }
        return link;
   }
}
