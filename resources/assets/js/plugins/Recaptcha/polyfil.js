const Deferred = () => {
    let result, resolve, reject;
    let state = false ;// Resolved or not

    return {
        /**
         *
         * @param value
         */
        resolve: (value) => {
            if (state) {
                return
            }
            state = true;

            if (resolve) {
                resolve(value);
            } else {
                result = result || new Promise((res) => { res(value); });
            }
        },

        /**
         *
         * @param reason
         */
        reject: (reason) => {
            if (reject) {
                reject(reason);
            } else {
                result = result || new Promise((_, rej) => { rej(reason); });
            }
        },

        /**
         * @return state
         */
        resolved: () => state,

        /**
         *
         */
        promise: new Promise((res, rej) => {
            if (result) {
                res(result);
            } else {
                resolve = res;
                reject = rej;
            }
        })
    };
};

export default Deferred