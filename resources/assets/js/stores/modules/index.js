const files = require.context('.', true, /\index.js$/);
const modules = {};

files.keys().forEach((file) => {
    if (file === './index.js') return;
    let name = file.replace(/(\.\/|\/index.js)/g, '');
    modules[name] = files(file).default
});

export default modules