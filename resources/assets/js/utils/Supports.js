import Vue from 'vue'
import { each } from 'lodash'

class EventBus {
    /**
     * Creates a new Event instance.
     */
    constructor() {
        /**
         * The Vue instance.
         *
         * @type {Vue}
         */
        this.bus = new Vue();
    }

    /**
     * Emit a given event.
     * @param {Object} event
     * @param args
     * @returns {EventBus}
     */
    emit(event, ...args) {
        this.bus.$emit(event, ...args)
    }

    /**
     * Listens for a given event.
     *
     * @param {Object} event
     * @param {Function} callback
     * @return {EventBus}
     */
    listen(event, callback) {
        if (arguments.length === 2) {
            this.bus.$on(arguments[0], arguments[1])
        } else {
            each(Object.keys(arguments[0]), key => this.bus.$on(key, arguments[0][key]))
        }
        //this.bus.$on(event, callback)
    }

    /**
     * Listens for a given event for once time only.
     *
     * @param {Object} event
     * @param {Function} callback
     * @return {EventBus}
     */
    listenOnce(event, callback) {
        this.bus.$once(event, callback)
    }

    /**
     * Removes listeners for a given event and callback.
     *
     * @param {Object} event
     * @param {Function} callback
     */
    remove(event, callback) {
        this.bus.$off(event, callback);
    }

    /**
     * Removes all listeners for a given event.
     *
     * @param {Object} event
     */
    removeListenersFrom(event) {
        this.bus.$off(event);
    }

    /**
     * Removes all event listeners.
     */
    removeAll() {
        this.bus.$off()
    }
}
export const event = new EventBus()

