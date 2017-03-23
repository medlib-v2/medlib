let colors = require('colors');

colors.setTheme({
    silly: 'rainbow',
    input: 'grey',
    verbose: 'cyan',
    prompt: 'grey',
    info: 'cyan',
    data: 'grey',
    help: 'cyan',
    warn: 'yellow',
    debug: 'blue',
    error: 'red',
    h1: 'grey',
    h2: 'yellow'
});

class Log {
    /**
     * Console log heading 1.
     *
     * @param  {string|object} message
     * @return {void}
     */
    title(message) {
        console.log(colors.bold(message));
    }

    /**
     * Console log heaing 2.
     *
     * @param  {string|object} message
     * @return {void}
     */
    subtitle(message) {
        console.log(colors.h2.bold(message));
    }

    /**
     * Console log info.
     *
     * @param  {string|object} message
     * @return {void}
     */
    info(message){
        console.log(colors.info(message));
    }

    /**
     * Console log success.
     *
     * @param  {string|object} message
     * @return {void}
     */
    success(message){
        console.log(colors.green('\u2714 '), message);
    }

    /**
     *
     *
     * Console log info.
     *
     * @param  {string|object} message
     * @return {void}
     */
    error(message){
        console.log(colors.error(message));
    }

    /**
     * Console log warning.
     *
     * @param  {string|object} message
     * @return {void}
     */
    warning(message){
        console.log(colors.warn('\u26A0 ' + message));
    }
}

module.exports = new Log;
