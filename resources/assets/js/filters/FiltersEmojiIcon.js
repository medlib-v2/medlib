import Vue from 'vue'
import emojione from 'emojione'


let options = {imageType: 'svg', sprites: true}

Object.assign(emojione, options)
if (emojione.sprites && emojione.imageType === 'svg') {
    emojione.imagePathSVGSprites = require('emojione/assets/sprites/emojione.sprites.svg')
}

Vue.filter('emoji', (value, method = 'toImage') => {
    return emojione[method](value)
})