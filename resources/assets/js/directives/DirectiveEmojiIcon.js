import Vue from 'vue'
import emojione from 'emojione'


let options = {imageType: 'svg', sprites: true}

Object.assign(emojione, options)
if (emojione.sprites && emojione.imageType === 'svg') {
    emojione.imagePathSVGSprites = require('emojione/assets/sprites/emojione.sprites.svg')
}

const emoji = (value, method = 'toImage') => emojione[method](value);

Vue.directive('emoji', {
    inserted(el, binding) {
        // Focus the element
        el.innerHTML = emoji(binding.value);
    }
})