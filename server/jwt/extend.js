let hasOwnProperty = Object.prototype.hasOwnProperty;

function extend() {
    let target = {}

    for (let i = 0; i < arguments.length; i++) {
        let source = arguments[i]

        for (let key in source) {
            if (hasOwnProperty.call(source, key)) {
                target[key] = source[key]
            }
        }
    }

    return target
}

module.exports = extend;
