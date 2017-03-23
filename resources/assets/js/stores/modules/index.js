const files = require.context('.', false, /\.js$/)
const modules = {}

files.keys().forEach((file) => {
    if (file === './index.js') return
    modules[file.replace(/(\.\/|\.js)/g, '')] = files(file).default
})

export default modules