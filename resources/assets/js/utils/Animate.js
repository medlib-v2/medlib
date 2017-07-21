
/**
 * Movement effect
 * @param {HTMLElement} element   Moving object, must be selected
 * @param {JSON}        target    Attribute: target value, must be selected
 * @param {number}      duration  Movement time, optional
 * @param {string}      mode      Movement mode, optional
 * @param {function}    callback  Optional, callback function, chain animation
 */
export const animate = (element, target, duration = 400, mode = 'ease-out', callback) => {
    clearInterval(element.timer);

    // Determine the different parameters of the situation
    if (duration instanceof Function) {
        callback = duration;
        duration = 400;
    } else if(duration instanceof String){
        mode = duration;
        duration = 400;
    }

    // Determine the different parameters of the situation
    if (mode instanceof Function) {
        callback = mode;
        mode = 'ease-out';
    }

    // Get the dom style
    const attrStyle = attr => {
        if (attr === "opacity") {
            return Math.round(getStyle(element, attr, 'float') * 100);
        } else {
            return getStyle(element, attr);
        }
    };

    // Root font size, need to change from rem to px operation
    const rootSize = parseFloat(document.documentElement.style.fontSize);

    const unit = {};
    const initState = {};

    // Get the target attribute unit and the initial style value
    Object.keys(target).forEach(attr => {
        if (/[^\d^\.]+/gi.test(target[attr])) {
            unit[attr] = target[attr].match(/[^\d^\.]+/gi)[0] || 'px';
        }else{
            unit[attr] = 'px';
        }
        initState[attr] = attrStyle(attr);
    });

    // Remove the incoming suffix unit
    Object.keys(target).forEach(attr => {
        if (unit[attr] == 'rem') {
            target[attr] = Math.ceil(parseInt(target[attr])*rootSize);
        }else{
            target[attr] = parseInt(target[attr]);
        }
    });

    let flag = true; // Assume that all movements reach the end point
    const remberSpeed = {}; // Record the previous speed value, in the ease-in mode need to use
    element.timer = setInterval(() => {
        Object.keys(target).forEach(attr => {
            // Step length
            let iSpeed = 0;
            // Whether still need to exercise
            let status = false;
            // Current element attribute address
            let iCurrent = attrStyle(attr) || 0;
            // The target point needs to be subtracted from the base value,
            // and the values ​​of the three motion states are different
            let speedBase = 0;
            // The target value is divided into the number of steps to implement,
            // the greater the value, the smaller the step, the longer the movement time
            let intervalTime;
            switch(mode){
                case 'ease-out':
                    speedBase = iCurrent;
                    intervalTime = duration*5/400;
                    break;
                case 'linear':
                    speedBase = initState[attr];
                    intervalTime = duration*20/400;
                    break;
                case 'ease-in':
                    let oldspeed = remberSpeed[attr] || 0;
                    iSpeed = oldspeed + (target[attr] - initState[attr])/duration;
                    remberSpeed[attr] = iSpeed;
                    break;
                default:
                    speedBase = iCurrent;
                    intervalTime = duration*5/400;
            }
            if (mode !== 'ease-in') {
                iSpeed = (target[attr] - speedBase) / intervalTime;
                iSpeed = iSpeed > 0 ? Math.ceil(iSpeed) : Math.floor(iSpeed);
            }
            // Determine whether the error distance within the step length,
            // if the arrival instructions to reach the target point
            switch(mode){
                case 'ease-out':
                    status = iCurrent != target[attr];
                    break;
                case 'linear':
                    status = Math.abs(Math.abs(iCurrent) - Math.abs(target[attr])) > Math.abs(iSpeed);
                    break;
                case 'ease-in':
                    status = Math.abs(Math.abs(iCurrent) - Math.abs(target[attr])) > Math.abs(iSpeed);
                    break;
                default:
                    status = iCurrent != target[attr];
            }

            if (status) {
                flag = false;
                // opacity and scrollTop require special handling
                if (attr === "opacity") {
                    element.style.filter = "alpha(opacity:" + (iCurrent + iSpeed) + ")";
                    element.style.opacity = (iCurrent + iSpeed) / 100;
                } else if (attr === 'scrollTop') {
                    element.scrollTop = iCurrent + iSpeed;
                }else{
                    element.style[attr] = iCurrent + iSpeed + 'px';
                }
            } else {
                flag = true;
            }

            if (flag) {
                clearInterval(element.timer);
                if (callback) {
                    callback();
                }
            }
        })
    }, 20);
};