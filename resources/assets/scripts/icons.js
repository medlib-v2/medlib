let fs = require('fs');
let path = require('path');
let icons = require('./icons/icons.json');
let moduleTpl = fs.readFileSync(path.resolve(__dirname, './icon.tpl'), 'utf8');
let ICON_PATH = path.resolve(__dirname, '../js/components/Icons/icons');

let indexModule = '';
let names = Object.keys(icons);
names.forEach(function (name) {
    let icon = {};
    icon[name] = icons[name];
    fs.writeFileSync(ICON_PATH + '/' + name + '.js', moduleTpl.replace('${icon}', JSON.stringify(icon)));
    indexModule += 'import \'./' + name + '\'\n';
});

fs.writeFileSync(ICON_PATH + '/index.js', indexModule);
console.log(names.length + ' icon modules generated.');
