import { SocketIOChannel } from './'

/**
 * This class represents a Socket.io presence channel.
 */
export class SocketIOPresenceChannel extends SocketIOChannel {

  constructor (socket, name, options) {
    super(socket, name, options)
  }

  /**
  * Register a callback to be called anytime the member list changes.
  *
  * @param  {Function} callback
  * @return {object} SocketIOPresenceChannel
  */
  here (callback) {
    this.on('presence:subscribed', (members) => {
      callback(members.map(m => m.user_info))
    })
    return this
  }

  /**
  * Listen for someone joining the channel.
  *
  * @param  {Function} callback
  * @return {SocketIOPresenceChannel}
  */
  joining (callback) {
    this.on('presence:joining', (member) => callback(member.user_info))
    return this
  }

  /**
  * Listen for someone leaving the channel.
  *
  * @param  {Function}  callback
  * @return {SocketIOPresenceChannel}
  */
  leaving (callback) {
    this.on('presence:leaving', (member) => callback(member.user_info))
    return this
  }
}