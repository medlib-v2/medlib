/**
 * Store Preview
 */
class PreviewStore {
    constructor () {
        this.state = { books: [], pageId: [], index: false };
        this.manger = {};
    }
    close () {
        this.state.index = false;
    }
}

export default new PreviewStore()