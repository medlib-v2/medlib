import $ from 'jquery'

const body = $('body')

export function getScrollBarWidth () {
    if (document.documentElement.scrollHeight <= document.documentElement.clientHeight) {
        return 0
    }
    let inner = document.createElement('p')
    inner.style.width = '100%'
    inner.style.height = '200px'

    let outer = document.createElement('div')
    outer.style.position = 'absolute'
    outer.style.top = '0px'
    outer.style.left = '0px'
    outer.style.visibility = 'hidden'
    outer.style.width = '200px'
    outer.style.height = '150px'
    outer.style.overflow = 'hidden'
    outer.appendChild(inner)

    document.body.appendChild(outer)
    let w1 = inner.offsetWidth
    outer.style.overflow = 'scroll'
    let w2 = inner.offsetWidth
    if (w1 === w2) w2 = outer.clientWidth

    document.body.removeChild(outer)

    return (w1 - w2)
}

// delayer: set a function that execute after a delay
// @params (function, delay_prop or value, default_value)
export function delayer (fn, varTimer, ifNaN = 100) {
    function toInt (el) { return /^[0-9]+$/.test(el) ? Number(el) || 1 : null }
    let timerId
    return (...args) => {
        if (timerId) clearTimeout(timerId)
        timerId = setTimeout(() => {
            fn.apply(this, args)
        }, toInt(varTimer) || toInt(this[varTimer]) || ifNaN)
    }
}

export function encodeHtml (str) {
    return str.replace(/</g, '&lt;').replace(/>/g, '&gt;')
}