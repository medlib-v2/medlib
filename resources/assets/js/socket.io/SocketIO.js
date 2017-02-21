import Vue from 'vue'
import { SocketIOConnector } from './connector'

/**
 * This class is the primary API for interacting with broadcasting.
 */
export default class SocketIO {

  constructor (connection, options) {
    this.connection = connection
    this.options = options
    if (typeof Vue === 'function' && Vue.http) {
      this.registerVueRequestInterceptor()
    }

    if (typeof axios === 'function') {
      this.registerAxiosRequestInterceptor()
    }

    if (typeof jQuery === 'function') {
      this.registerjQueryAjaxSetup()
    }
    this.connector = new SocketIOConnector(this.connection, this.options)
  }

  /**
  * Register a Vue HTTP interceptor to add the X-Socket-ID header.
  */
  registerVueRequestInterceptor () {
    Vue.http.interceptors.push((request, next) => {
      if (this.socketId()) {
        request.headers.set('X-Socket-ID', this.socketId())
      }
      next()
    })
  }

  /**
  * Register an Axios HTTP interceptor to add the X-Socket-ID header.
  */
  registerAxiosRequestInterceptor () {

    axios.interceptors.request.use((config) => {
      if (this.socketId()) {
        config.headers['X-Socket-Id'] = this.socketId()
      }
      return config
    })
  }

  /**
  * Register jQuery AjaxSetup to add the X-Socket-ID header.
  */
  registerjQueryAjaxSetup () {

    jQuery.ajaxSetup({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-Socket-Id', this.socketId())
      }
    })
  }

  /**
  * Listen for an event on a channel instance.
  */
  listen (channel, event, callback) {
    return this.connector.listen(channel, event, callback)
  }

  /**
  * Get a channel instance by name.
  *
  * @param  {string}  channel
  * @return {object}
  */
  channel (channel) {
    return this.connector.channel(channel)
  }

  /**
  * Get a private channel instance by name.
  *
  * @param  {string} channel
  * @return {object}
  */
  private (channel) {
    return this.connector.privateChannel(channel)
  }

  /**
  * Get a presence channel instance by name.
  *
  * @param  {string} channel
  * @return {object}
  */
  join (channel) {
    return this.connector.presenceChannel(channel)
  }

  /**
  * Leave the given channel.
  *
  * @param  {string} channel
  */
  leave (channel) {
    this.connector.leave(channel)
  }

  /**
  * Leave the any channel.
  * @param channel
  * @param callback
  */
  on (channel, callback) {
    this.connector.on(channel, callback)
  }

  /**
  *
  * @param channel
  * @param data
  */
  emit (channel, data) {
    this.connector.emit(channel, data)
  }

  /**
  * Get the Socket ID for the connection.
  *
  * @return {string}
  */
  socketId () {
    return this.connector.socketId()
  }
}
