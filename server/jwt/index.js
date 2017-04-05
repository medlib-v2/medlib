let jwt = require('jsonwebtoken');
let extend = require('./extend');
let UnauthorizedError = require('./UnauthorizedError');

function noQsMethod(options) {
  let defaults = { required: true };
  options = extend(defaults, options);

  return function (socket) {
    let server = this.server || socket.server;

    if (!server.$emit) {
      //then is socket.io 1.0
      let Namespace = Object.getPrototypeOf(server.sockets).constructor;
      if (!~Namespace.events.indexOf('authenticated')) {
        Namespace.events.push('authenticated');
      }
    }

    if(options.required){
      let auth_timeout = setTimeout(function () {
        socket.disconnect('unauthorized');
      }, options.timeout || 5000);
    }

    socket.on('authenticate', function (data) {
      if(options.required){
        clearTimeout(auth_timeout);
      }
      // error handler
      let onError = function(err, code) {
          if (err) {
            code = code || 'unknown';
            let error = new UnauthorizedError(code, {
              message: (Object.prototype.toString.call(err) === '[object Object]' && err.message) ? err.message : err
            });
            let callback_timeout;
            // If callback explicitely set to false, start timeout to disconnect socket
            if (options.callback === false || typeof options.callback === "number") {
              if (typeof options.callback === "number") {
                if (options.callback < 0) {
                  // If callback is negative(invalid value), make it positive
                  options.callback = Math.abs(options.callback);
                }
              }
              callback_timeout = setTimeout(function () {
                socket.disconnect('unauthorized');
              }, (options.callback === false ? 0 : options.callback));
            }
            socket.emit('unauthorized', error, function() {
              if (typeof options.callback === "number") {
                clearTimeout(callback_timeout);
              }
              socket.disconnect('unauthorized');
            });
            return; // stop logic, socket will be close on next tick
          }
      };

      if(!data || typeof data.token !== "string") {
        return onError({message: 'invalid token datatype'}, 'invalid_token');
      }

      let onJwtVerificationReady = function(err, decoded) {

        if (err) {
          return onError(err, 'invalid_token');
        }

        // success handler
        let onSuccess = function() {
          socket[options.decodedPropertyName] = decoded;
          socket.emit('authenticated');
          if (server.$emit) {
            server.$emit('authenticated', socket);
          } else {
            //try getting the current namespace otherwise fallback to all sockets.
            let namespace = (server.nsps && socket.nsp &&
                             server.nsps[socket.nsp.name]) ||
                            server.sockets;

            // explicit namespace
            namespace.emit('authenticated', socket);
          }
        };

        if(options.additional_auth && typeof options.additional_auth === 'function') {
          options.additional_auth(decoded, onSuccess, onError);
        } else {
          onSuccess();
        }
      };

      let onSecretReady = function(err, secret) {
        if (err || !secret) {
          return onError(err, 'invalid_secret');
        }

        jwt.verify(data.token, secret, options, onJwtVerificationReady);
      };

      getSecret(socket.request, options.secret, data.token, onSecretReady);
    });
  };
}

function authorize(options, onConnection) {
  options = extend({ decodedPropertyName: 'decoded_token' }, options);

  if (!options.handshake) {
    return noQsMethod(options);
  }

  let defaults = {
    success: function(data, accept){
      if (data.request) {
        accept();
      } else {
        accept(null, true);
      }
    },
    fail: function(error, data, accept){
      if (data.request) {
        accept(error);
      } else {
        accept(null, false);
      }
    }
  };

  let auth = extend(defaults, options);

  return function(data, accept){
    let token, error;
    let req = data.request || data;
    let authorization_header = (req.headers || {}).authorization;

    if (authorization_header) {
      let parts = authorization_header.split(' ');
      if (parts.length == 2) {
        let scheme = parts[0],
          credentials = parts[1];

        if (scheme.toLowerCase() === 'bearer') {
          token = credentials;
        }
      } else {
        error = new UnauthorizedError('credentials_bad_format', {
          message: 'Format is Authorization: Bearer [token]'
        });
        return auth.fail(error, data, accept);
      }
    }

    //get the token from query string
    if (req._query && req._query.token) {
      token = req._query.token;
    }
    else if (req.query && req.query.token) {
      token = req.query.token;
    }

    if (!token) {
      error = new UnauthorizedError('credentials_required', {
        message: 'No Authorization header was found'
      });
      return auth.fail(error, data, accept);
    }

    let onJwtVerificationReady = function(err, decoded) {

      if (err) {
        error = new UnauthorizedError(err.code || 'invalid_token', err);
        return auth.fail(error, data, accept);
      }

      data[options.decodedPropertyName] = decoded;

      return auth.success(data, accept);
    };

    let onSecretReady = function(err, secret) {
      if (err) {
        error = new UnauthorizedError(err.code || 'invalid_secret', err);
        return auth.fail(error, data, accept);
      }

      jwt.verify(token, secret, options, onJwtVerificationReady);
    };

    getSecret(req, options.secret, token, onSecretReady);
  };
}

function getSecret(request, secret, token, callback) {
  if (typeof secret === 'function') {
    if (!token) {
      return callback({ code: 'invalid_token', message: 'jwt must be provided' });
    }

    let parts = token.split('.');

    if (parts.length < 3) {
      return callback({ code: 'invalid_token', message: 'jwt malformed' });
    }

    if (parts[2].trim() === '') {
      return callback({ code: 'invalid_token', message: 'jwt signature is required' });
    }

    let decodedToken = jwt.decode(token);

    if (!decodedToken) {
      return callback({ code: 'invalid_token', message: 'jwt malformed' });
    }

    secret(request, decodedToken, callback);
  } else {
    callback(null, secret);
  }
};

exports.authorize = authorize;
