const req = require.context('.', true, /\.js$/);
const files = req.keys();
const routes = [];

files.map((file) => {
    if (file === './index.js') return;
    let route = req(file);
    routes.push(route.default);
});

export default routes;