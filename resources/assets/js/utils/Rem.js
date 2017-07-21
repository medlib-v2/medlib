((doc, win) => {
    let docEl = doc.documentElement,
        resizeEvt = 'orientationchange' in win ? 'oorientationchange': 'resize',
        reCalc = () => {
            let clientWidth = docEl.clientWidth;
            if (!clientWidth) return;
            docEl.style.fontSize = 20 * (clientWidth / 320) + 'px';
        };
    if (!doc.addEventListener) return;
    win.addEventListener(resizeEvt, reCalc, false);
    doc.addEventListener('DOMContentLoaded', reCalc, false);
})(document, window);