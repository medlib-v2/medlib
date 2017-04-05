let PresenceChannel = require('./presence-channel'),
    PrivateChannel = require('./private-channel'),
    Log = require('./../log');

class Channel {
    /**
     * Create a new channel instance.
     */
    constructor(io, options) {
        /**
         * Socket io instance.
         *
         * @type {Socket}
         */
        this.io = io;
        
        /**
         * Options.
         *
         * @type {Object}
         */
        this.options = options;
        /**
         * Channels and patters for private channels.
         *
         * @type {array}
         */
        this._privateChannels = ['private-*', 'presence-*'];

        /**
         * Allowed client events
         *
         * @type {array}
         */
        this._clientEvents = ['client-*'];

        /**
         * Private channel instance.
         *
         * @type {PrivateChannel}
         */
        this.private = new PrivateChannel(options);

        /**
         * Presence channel instance.
         *
         * @type {PresenceChannel}
         */
        this.presence = new PresenceChannel(io, options);

        Log.success('Channels are ready.');
    }

    /**
     * Join a channel.
     *
     * @param  {object} socket
     * @param  {object} data
     * @return {void}
     */
    join(socket, data) {
        if (data.channel) {
            if (this.isPrivate(data.channel)) {
                this.joinPrivate(socket, data);
            } else {
                socket.join(data.channel);
                this.onJoin(socket, data.channel);
            }
        }
    }

    /**
     * Trigger a client message
     *
     * @param  {object} socket
     * @param  {object} data
     * @return {void}
     */
    clientEvent(socket, data) {
        if (data.event && data.channel) {
            if (this.isClientEvent(data.event) && this.isPrivate(data.channel) && this.isInChannel(socket, data.channel)) {
                this.io.sockets.connected[socket.id]
                    .broadcast.to(data.channel)
                    .emit(data.event, data.channel, data.data);
            }
        }
    }

    /**
     * Leave a channel.
     *
     * @param  {object} socket
     * @param  {string} channel
     * @param  {string} reason
     * @return {void}
     */
    leave(socket, channel, reason) {
        if (channel) {
            if (this.isPresence(channel)) {
                this.presence.leave(socket, channel)
            }

            socket.leave(channel);

            if (this.options.devMode) {
                Log.info(`[${new Date().toLocaleTimeString()}] - ${socket.id} left channel: ${channel} (${reason})`);
            }
        }
    }

    /**
     * Check if the incoming socket connection is a private channel.
     *
     * @param  {string} channel
     * @return {boolean}
     */
    isPrivate(channel) {
        let isPrivate = false;

        this._privateChannels.forEach(privateChannel => {
            let regex = new RegExp(privateChannel.replace('\*', '.*'));
            if (regex.test(channel)) isPrivate = true;
        });

        return isPrivate;
    }

    /**
     * Join private channel, emit data to presence channels.
     *
     * @param  {object} socket
     * @param  {object} data
     * @return {void}
     */
    joinPrivate(socket, data) {
        this.private.authenticate(socket, data).then(res => {
            socket.join(data.channel);

            if (this.isPresence(data.channel)) {
                let member = res.channel_data;
                try {
                    member = JSON.parse(res.channel_data);
                } catch (e) {
                }

                this.presence.join(socket, data.channel, member);
            }

            this.onJoin(socket, data.channel);
        }, error => {
            Log.error(error.reason);

            this.io.sockets.to(socket.id)
                .emit('subscription_error', data.channel, error.status);
        });
    }

    /**
     * Check if a channel is a presence channel.
     *
     * @param  {string} channel
     * @return {boolean}
     */
    isPresence(channel) {
        return channel.lastIndexOf('presence-', 0) === 0;
    }

    /**
     * On join a channel log success.
     *
     * @param {any} socket
     * @param {string} channel
     */
    onJoin(socket, channel) {
        if (this.options.devMode) {
            Log.info(`[${new Date().toLocaleTimeString()}] - ${socket.id} joined channel: ${channel}`);
        }
    }

    /**
     * Check if client is a client event
     *
     * @param  {string} event
     * @return {boolean}
     */
    isClientEvent(event) {
        let isClientEvent = false;

        this._clientEvents.forEach(clientEvent => {
            let regex = new RegExp(clientEvent.replace('\*', '.*'));
            if (regex.test(event)) isClientEvent = true;
        });

        return isClientEvent;
    }

    /**
     * Check if a socket has joined a channel.
     *
     * @param socket
     * @param channel
     * @returns {boolean}
     */
    isInChannel(socket, channel) {
        return !!socket.rooms[channel];
    }
}

module.exports = Channel;
