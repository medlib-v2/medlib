# Vue-Icons

> Font Awesome component for Vue.js, using inline SVG.

Vue-Icons is built upon [Font Awesome](https://github.com/FortAwesome/Font-Awesome) `v4.5.0` and depends on [Vue.js](https://vuejs.org/) `v2.0.1`+.

Check out the demo [here](../example).

### ES Modules with NPM & vue-loader (Recommended)

```js
import Vue from 'vue'

/* Pick one way between the 2 following ways */

// only import the icons you use to reduce bundle size
import '@/components/Icons/icons/flag'

// or import all icons if you don't care about bundle size
import '@/components/Icons/icons'

/* Register component with one of 2 methods */

import Icon from '@/components/Icons/Icon'

// globally (in your main .js file)
Vue.component('icon', Icon)

// or locally (in your component file)
export default {
  components: {
    Icon
  }
}
```

## Styling

### Dynamic sizing

You can make the icons scale dynamically according to your `font-size` by adding the following CSS:

```css
.fa-icon {
  width: auto;
  height: 1em; /* or any other relative font sizes */
}
```

### Colors

The icon color is inherited from the font color of the parent element by default. You can easily change it to any other color by specifying the `color` property.

### Updating icons

Don't touch files in `assets/js/components/Icons/icons` but update `assets/scripts/icons/icons.json` instead and run `npm run icons` to re-generate icon module files.

## Registering custom icons

You can register custom icons like this:

```js
// ES Modules with vue-loader
import Icon from '@/components/Icons/Icon.vue'

Icon.register({
  taobao: {
    width: 1792,
    height: 1374,
    d: 'M312,313 C401,313 473,249 473,169 C473,90 401,25 312,25 C223,25 151,90 151,169 C151,249 223,313 312,313 L312,313 Z M178,372 L77,527 L264,644 C264,644 389,707 330,827 C274,940 2,1188 2,1188 L246,1340 C414,974 404,1023 446,891 C489,757 499,654 425,580 C330,485 319,476 178,372 L178,372 Z M1760,331 C1760,331 1708,-81 806,174 C844,107 863,63 863,63 L638,0 C638,0 547,296 385,435 C385,435 542,525 540,522 C585,478 625,432 660,388 C696,372 731,357 765,343 C723,419 656,531 588,602 L683,685 C683,685 748,622 819,547 L899,547 L899,686 L585,686 L585,796 L899,796 L899,1062 C895,1061 891,1061 887,1061 C853,1059 798,1054 778,1020 C752,980 771,905 772,859 L555,859 L547,863 C547,863 468,1219 777,1211 C1065,1219 1231,1131 1310,1070 L1342,1188 L1520,1114 L1399,819 L1255,863 L1282,965 C1245,992 1202,1013 1156,1028 L1156,796 L1462,796 L1462,686 L1156,686 L1156,547 L1464,547 L1464,437 L917,437 C956,389 987,345 996,317 L900,291 C1309,145 1537,170 1535,410 L1535,1042 C1535,1042 1559,1259 1310,1244 L1176,1215 L1144,1343 C1144,1343 1725,1508 1772,1062 C1820,615 1760,331 1760,331 L1760,331 Z'
  }
})
```

Default icon size should be `1792x1792` and will be normalized to `16x16`.


## Badges

![](https://img.shields.io/badge/license-MIT-blue.svg)
![](https://img.shields.io/badge/status-stable-green.svg)

---

> [medlib.fr](https://medlib.fr) &nbsp;&middot;&nbsp;
> GitHub [@medlib](https://github.com/medlib-v2) &nbsp;&middot;&nbsp;
> Twitter [@medlib](https://twitter.com/medlib)
