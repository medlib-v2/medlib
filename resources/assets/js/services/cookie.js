

class Cookie {
    constructor() {
        /**
         * Module variables.
         * @private
         */

        this.decode = decodeURIComponent;
        this.encode = encodeURIComponent;
        this.pairSplitRegExp = /; */;

        /**
         * RegExp to match field-content in RFC 7230 sec 3.2
         *
         * field-content = field-vchar [ 1*( SP / HTAB ) field-vchar ]
         * field-vchar   = VCHAR / obs-text
         * obs-text      = %x80-FF
         */

        this.fieldContentRegExp = /^[\u0009\u0020-\u007e\u0080-\u00ff]+$/;
    }

    /**
     * Serialize data into a cookie header.
     *
     * Serialize the a name value pair into a cookie string suitable for
     * http headers. An optional options object specified cookie parameters.
     *
     * serialize('foo', 'bar', { httpOnly: true })
     *   => "foo=bar; httpOnly"
     *
     * @param {string} name
     * @param {string} val
     * @param {object} [options]
     * @return {string}
     * @public
     */
    serialize(name, val, options) {
        let opt = options || {};
        let enc = opt.encode || this.encode;

        if (typeof enc !== 'function') {
            throw new TypeError('option encode is invalid');
        }

        if (!this.fieldContentRegExp.test(name)) {
            throw new TypeError('argument name is invalid');
        }

        let value = enc(val);

        if (value && !this.fieldContentRegExp.test(value)) {
            throw new TypeError('argument val is invalid');
        }

        let str = name + '=' + value;

        if (null !== opt.maxAge) {
            let maxAge = opt.maxAge - 0;
            if (isNaN(maxAge)) throw new Error('maxAge should be a Number');
            str += '; Max-Age=' + Math.floor(maxAge);
        }

        if (opt.domain) {
            if (!this.fieldContentRegExp.test(opt.domain)) {
                throw new TypeError('option domain is invalid');
            }

            str += '; Domain=' + opt.domain;
        }

        if (opt.path) {
            if (!this.fieldContentRegExp.test(opt.path)) {
                throw new TypeError('option path is invalid');
            }

            str += '; Path=' + opt.path;
        }

        if (opt.expires) {
            if (typeof opt.expires.toUTCString !== 'function') {
                throw new TypeError('option expires is invalid');
            }

            str += '; Expires=' + opt.expires.toUTCString();
        }

        if (opt.httpOnly) {
            str += '; HttpOnly';
        }

        if (opt.secure) {
            str += '; Secure';
        }

        if (opt.sameSite) {
            let sameSite = typeof opt.sameSite === 'string'
                ? opt.sameSite.toLowerCase() : opt.sameSite;

            switch (sameSite) {
                case true:
                    str += '; SameSite=Strict';
                    break;
                case 'lax':
                    str += '; SameSite=Lax';
                    break;
                case 'strict':
                    str += '; SameSite=Strict';
                    break;
                default:
                    throw new TypeError('option sameSite is invalid');
            }
        }

        return str;
    }

    /**
     * Parse a cookie header.
     *
     * Parse the given cookie header string into an object
     * The object has the various cookies as keys(names) => values
     *
     * @param {string} str
     * @param {object} [options]
     * @return {object}
     * @public
     */

    parse(str, options) {
        if (typeof str !== 'string') {
            throw new TypeError('argument str must be a string');
        }

        let obj = {};
        let opt = options || {};
        let pairs = str.split(this.pairSplitRegExp);
        let dec = opt.decode || this.decode;

        for (let i = 0; i < pairs.length; i++) {
            let pair = pairs[i];
            let eq_idx = pair.indexOf('=');

            /**
             * skip things that don't look like key=value
             */
            if (eq_idx < 0) {
                continue;
            }

            let key = pair.substr(0, eq_idx).trim();
            let val = pair.substr(++eq_idx, pair.length).trim();

            /**
             * quoted values
             */
            if ('"' === val[0]) {
                val = val.slice(1, -1);
            }

            /**
             * only assign once
             */
            if (undefined === obj[key]) {
                obj[key] = this._tryDecode(val, dec);
            }
        }

        return obj;
    }

    /**
     * Try decoding a string using a decoding function.
     *
     * @param {string} str
     * @param {function} decode
     * @private
     */
    _tryDecode(str, decode) {
        try {
            return decode(str);
        } catch (e) {
            return str;
        }
    }
}

/**
 * Module exports.
 * @public
 */
const cookie = new Cookie();
export default cookie;