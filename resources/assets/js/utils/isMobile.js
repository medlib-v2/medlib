class IsMobile {
    constructor() {
        this.regex = {
            apple_phone         : /iPhone/i,
            apple_ipod          : /iPod/i,
            apple_tablet        : /iPad/i,
            android_phone       : /(?=.*\bAndroid\b)(?=.*\bMobile\b)/i, // Match 'Android' AND 'Mobile'
            android_tablet      : /Android/i,
            amazon_phone        : /(?=.*\bAndroid\b)(?=.*\bSD4930UR\b)/i,
            amazon_tablet       : /(?=.*\bAndroid\b)(?=.*\b(?:KFOT|KFTT|KFJWI|KFJWA|KFSOWI|KFTHWI|KFTHWA|KFAPWI|KFAPWA|KFARWI|KFASWI|KFSAWI|KFSAWA)\b)/i,
            windows_phone       : /Windows Phone/i,
            windows_tablet      : /(?=.*\bWindows\b)(?=.*\bARM\b)/i, // Match 'Windows' AND 'ARM'
            other_blackberry    : /BlackBerry/i,
            other_blackberry_10 : /BB10/i,
            other_opera         : /Opera Mini/i,
            other_chrome        : /(CriOS|Chrome)(?=.*\bMobile\b)/i,
            other_firefox       : /(?=.*\bFirefox\b)(?=.*\bMobile\b)/i, // Match 'Firefox' AND 'Mobile'
            seven_inch : new RegExp(
                '(?:' +         // Non-capturing group

                'Nexus 7' +     // Nexus 7

                '|' +           // OR

                'BNTV250' +     // B&N Nook Tablet 7 inch

                '|' +           // OR

                'Kindle Fire' + // Kindle Fire

                '|' +           // OR

                'Silk' +        // Kindle Fire, Silk Accelerated

                '|' +           // OR

                'GT-P1000' +    // Galaxy Tab 7 inch

                ')',            // End non-capturing group

                'i')           // Case-insensitive matching
        };
        this.parse();
    }

    /**
     *
     * @param regex
     * @param userAgent
     */
    match (regex, userAgent) {
        return regex.test(userAgent);
    };

    /**
     *
     * @param userAgent
     * @return {isMobile}
     * @constructor
     */
    parse = (userAgent) => {
        let ua = userAgent || navigator.userAgent;

        // Facebook mobile app's integrated browser adds a bunch of strings that
        // match everything. Strip it out if it exists.
        let tmp = ua.split('[FBAN');
        if (typeof tmp[1] !== 'undefined') {
            ua = tmp[0];
        }

        // Twitter mobile app's integrated browser on iPad adds a "Twitter for
        // iPhone" string. Same probable happens on other tablet platforms.
        // This will confuse detection so strip it out if it exists.
        tmp = ua.split('Twitter');
        if (typeof tmp[1] !== 'undefined') {
            ua = tmp[0];
        }

        this.apple = {
            phone:  this.match(this.regex.apple_phone, ua),
            ipod:   this.match(this.regex.apple_ipod, ua),
            tablet: !this.match(this.regex.apple_phone, ua) && this.match(this.regex.apple_tablet, ua),
            device: this.match(this.regex.apple_phone, ua) || this.match(this.regex.apple_ipod, ua) || this.match(this.regex.apple_tablet, ua)
        };
        this.amazon = {
            phone:  this.match(this.regex.amazon_phone, ua),
            tablet: !this.match(this.regex.amazon_phone, ua) && this.match(this.regex.amazon_tablet, ua),
            device: this.match(this.regex.amazon_phone, ua) || this.match(this.regex.amazon_tablet, ua)
        };
        this.android = {
            phone:  this.match(this.regex.amazon_phone, ua) || this.match(this.regex.android_phone, ua),
            tablet: !this.match(this.regex.amazon_phone, ua) && !this.match(this.regex.android_phone, ua) && (this.match(this.regex.amazon_tablet, ua) || this.match(this.regex.android_tablet, ua)),
            device: this.match(this.regex.amazon_phone, ua) || this.match(this.regex.amazon_tablet, ua) || this.match(this.regex.android_phone, ua) || this.match(this.regex.android_tablet, ua)
        };
        this.windows = {
            phone:  this.match(this.regex.windows_phone, ua),
            tablet: this.match(this.regex.windows_tablet, ua),
            device: this.match(this.regex.windows_phone, ua) || this.match(this.regex.windows_tablet, ua)
        };
        this.other = {
            blackberry:   this.match(this.regex.other_blackberry, ua),
            blackberry10: this.match(this.regex.other_blackberry_10, ua),
            opera:        this.match(this.regex.other_opera, ua),
            firefox:      this.match(this.regex.other_firefox, ua),
            chrome:       this.match(this.regex.other_chrome, ua),
            device:       this.match(this.regex.other_blackberry, ua) || this.match(this.regex.other_blackberry_10, ua) || this.match(this.regex.other_opera, ua) || this.match(this.regex.other_firefox, ua) || this.match(this.regex.other_chrome, ua)
        };
        this.seven_inch = this.match(this.regex.seven_inch, ua);
        this.any = this.apple.device || this.android.device || this.windows.device || this.other.device || this.seven_inch;

        /**
         * excludes 'other' devices and ipods, targeting touchscreen phones
         * @type {boolean|*}
         */
        this.phone = this.apple.phone || this.android.phone || this.windows.phone;

        /**
         * excludes 7 inch devices, classifying as phone or tablet is left to the user
         * @type {boolean|*}
         */
        this.tablet = this.apple.tablet || this.android.tablet || this.windows.tablet;

        /**
         *
         * @return {boolean|*}
         */
        this.isAny = () => {
            return (this.isAndroid() || this.isBlackBerry() || this.isIOS() || this.isOpera() || this.isWindows());
        };

        /**
         *
         * @return {boolean|*}
         */
        this.isAndroid = () => {
            return this.android.device;
        };

        /**
         *
         * @return {boolean|*}
         */
        this.isBlackBerry = () => {
            return this.other.blackberry || this.other.blackberry10;
        };

        /**
         *
         * @return {boolean|*}
         */
        this.isIOS = () => {
            return this.apple.device;
        };

        /**
         *
         * @return {boolean|*}
         */
        this.isOpera = () => {
            return this.other.opera;
        };

        /**
         *
         * @return {boolean|*}
         */
        this.isWindows = () => {
            return this.windows.device;
        };

        /**
         *
         * @return {boolean|*}
         */
        this.isAmazon = () => {
            return this.amazon.device;
        };

        /**
         *
         * @return {boolean|*}
         */
        this.isPhone = () => {
            return this.phone
        };

        /**
         *
         * @return {boolean|*}
         */
        this.isTablet = () => {
            return this.tablet;
        };

        return this;
    }
}

let installed = false;
const isMobile = new IsMobile();

export default (Vue, options) => {
    if (installed) return;

    installed = true;

    Vue.prototype.isMobile = isMobile;
}