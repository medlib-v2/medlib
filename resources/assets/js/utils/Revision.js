/**
 * Revision
 * @param filename
 * @return {String}
 */
export const mix = (filename) => {
    let json = require('../../../../public/mix-manifest.json');
    for (let prop in json) if(filename === prop) return json[prop];
    return filename;
};