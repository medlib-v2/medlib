/**
 * This class represents a basic channel.
 */
export class Channel {
  /**
  * Listen for an event on the channel instance.
  *
  * @param  {Function} callback
  * @return {Channel}
  */
  notification (callback) {
    return this.listen('.Illuminate.Notifications.Events.BroadcastNotificationCreated', callback)
  }

  /**
  * Listen for a whisper event on the channel instance.
  *
  * @param  {string} event
  * @param  {Function}   callback
  * @return {SocketIoChannel}
  */
  listenForWhisper (event, callback) {
    return this.listen('.client-' + event, callback)
  }
}
