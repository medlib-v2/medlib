/**
 * Event name formatter
 */
export class EventFormatter {
  /**
  * Create a new class instance.
  *
  * @params  {string | boolean} namespace
  */
  constructor (namespace) {
    this.namespace = null
    this.setNamespace(namespace)
  }

  /**
  * Format the given event name.
  *
  * @param  {string} event
  * @return {string}
  */
  format (event) {
    if (this.namespace) {
      if (event.charAt(0) !== '\\' && event.charAt(0) !== '.') {
        event = this.namespace + '.' + event
      } else {
        event = event.substr(1)
      }
    }
    return event.replace(/\./g, '\\')
  }

  /**
  * Set the event namespace.
  *
  * @param  {string} value
  * @return {void}
  */
  setNamespace (value) {
    this.namespace = value
  }
}
