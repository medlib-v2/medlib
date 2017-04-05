import { SocketIOChannel } from './'

/**
 * This class represents a Socket.io presence channel.
 */
export class SocketIOPrivateChannel extends SocketIOChannel {

  constructor (socket, name, options) {
    super(socket, name, options)
    this.socket = socket
    this.name = name
    this.options = options
  }

  /**
  * Trigger client event on the channel.
  *
  * @param  {string}  eventName
  * @param  {object}  data
  * @return {SocketIOPrivateChannel}
  */
  whisper (eventName, data) {
    this.socket.emit('client event', {
      channel: this.name,
      event: `client-${eventName}`,
      data: data
    })
    return this
  }
}
