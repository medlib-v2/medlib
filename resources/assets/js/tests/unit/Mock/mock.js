export default {

    // basic mock
    ['GET */path/to/resource'] (pathMatch, query, request) {
        // before respond, you can check the path and query parameters with `pathMatch` & `query`
        // powered by 'url-pattern' & 'qs'
        // https://www.npmjs.com/package/url-pattern
        // https://www.npmjs.com/package/qs
        let body = { /* whatever */ };
        return {
            body: body,
            status: 200,
            statusText: 'OK',
            headers: { /*headers*/ },
            delay: 500, // millisecond
        }
    },

    ['POST */auth/login'] (pathMatch, query, request) {
        let body = { /* whatever */ };
        return {
            body: body,
            status: 200,
            statusText: 'OK',
            headers: { /*headers*/ },
            delay: 500, // millisecond
        }
    },

    ['POST */auth/error'] (pathMatch, query, request) {
        let body = {
            'username': ['Value is required']
        };
        return {
            body: body,
            status: 422,
            statusText: 'OK',
            headers: { /*headers*/ },
            delay: 500, // millisecond
        }
    },

    ['PUT */user/photo'] (pathMatch, query, request) {
        let body = {
            username: 'foo',
            password: 'bar',
            photo: new Blob([new Uint8Array(10)], { type: 'image/png' })
        };
        return {
            body: body,
            status: 422,
            statusText: 'OK',
            headers: { /*headers*/ },
            delay: 500, // millisecond
        }
    },

    // shorthand mock
    //['PUT */path/to/resource'] = 200 // respond with only status code

    //['POST */path/to/resource'] = { /*whatever*/ } // respond with only body, status code = 200

}