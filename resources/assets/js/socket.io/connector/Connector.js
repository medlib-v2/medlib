import Socket from 'socket.io-client'
import { SocketIOChannel, SocketIOPrivateChannel, SocketIOPresenceChannel } from '../channel'

/**
 * This class creates a connnector to a Socket.io server.
 */
export class SocketIOConnector {
  /**
  * The Socket.io connection instance.
  *
  * @type {object} options
  */
  constructor (connection, options) {
    this.defaultOptions = {
      auth: {
        headers: {}
      },
      authEndpoint: '/broadcasting/auth',
      csrfToken: null,
      namespace: 'Medlib.Events'
    }
    this.options = {}
    this.socket = {}
    this.channels = {}
    this.host = null
    this.setOptions(options)
    this.connect(connection)
  }

  /**
  * Connector options.
  *
  * @type {object}
  */
  setOptions (options) {
    this.options = Object.assign(this.defaultOptions, options)

    if (this.csrfToken()) {
      this.options.auth.headers['X-CSRF-TOKEN'] = this.csrfToken()
    }
    return options
  }

  /**
  * Extract the CSRF token from the page.
  *
  * @return {string}
  */
  csrfToken () {
    let selector
    if (window && window['Setting'] && window['Setting'].csrfToken) {
      return window['Setting'].csrfToken
    } else if (this.options.csrfToken) {
      return this.options.csrfToken
    } else if (document && (selector = document.querySelector('meta[name="csrf-token"]'))) {
      return selector.getAttribute('content')
    }
    return null
  }

  /**
  * Create a fresh Socket.io connection.
  * @param {object||string} host
  * @return void
  */
  connect (host) {
    if (typeof host === 'string') {
      this.socket = Socket(host, this.options)
    } else {
      this.socket = host
    }
    return this.socket
  }

  /**
  * Listen for an event on a channel instance.
  *
  * @param  {string} name
  * @param  {string} event
  * @param  {Function} callback
  * @return {SocketIOChannel}
  */
  listen (name, event, callback) {
    return this.channel(name).listen(event, callback)
  }

  /**
  * Get a channel instance by name.
  *
  * @param  {string} name
  * @return {SocketIOChannel}
  */
  channel (name) {
    if (!this.channels[name]) {
      this.channels[name] = new SocketIOChannel(this.socket, name, this.options)
    }
    return this.channels[name]
  }

  /**
  * Get a private channel instance by name.
  *
  * @param  {string} name
  * @return {SocketIOChannel}
  */
  privateChannel (name) {
    if (!this.channels['private-' + name]) {
      this.channels['private-' + name] = new SocketIOPrivateChannel(this.socket, 'private-' + name, this.options)
    }
    return this.channels['private-' + name]
  }

  /**
  * Get a presence channel instance by name.
  *
  * @param  {string} name
  * @return {SocketIOPresenceChannel}
  */
  presenceChannel (name) {
    if (!this.channels['presence-' + name]) {
      this.channels['presence-' + name] = new SocketIOPresenceChannel(this.socket, 'presence-' + name, this.options)
    }
    return this.channels['presence-' + name]
  }

  /**
  * Leave the given channel.
  *
  * @param  {string} name
  * @return {void}
  */
  leave (name) {
    let channels = [name, 'private-' + name, 'presence-' + name]

    channels.forEach(name => {
      if (this.channels[name]) {
        this.channels[name].unsubscribe()
        delete this.channels[name]
      }
    })
  }

  /**
  * Leave the any channel.
  *
  * @param name
  * @param callback
  */
  on (name, callback) {
    this.socket.on(name, callback)
  }

  /**
  *
  * @param name
  * @param data
  */
  emit (name, data = {}) {
    this.socket.emit(name, data)
  }

  /**
  * Get the socket ID for the connection.
  *
  * @return {string}
  */
  socketId () {
    return this.socket.id
  }
}
