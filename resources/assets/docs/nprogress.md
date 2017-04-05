
# NProgress

Petite Progress bars bassée sur [nprogress](https://github.com/rstacruz/nprogress) pour les applications Ajax


## Exemples

```vue
<template>
  <nprogress-container></nprogress-container>
</template>

<script>
import NprogressContainer from './components/Nprogress/Nprogress'

export default {
  components: {
    NprogressContainer
  }
}
</script>
```

```js
import Vue from 'vue'
import NProgress from './components/Nprogress'
import App from './App.vue'

Vue.use(NProgress)

const nprogress = new NProgress({ parent: '.nprogress-container' })

const app = new Vue({
  nprogress
  ...App
})

// APIs: see https://github.com/rstacruz/nprogress
// app.nprogress
// app.nprogress.start()
// app.nprogress.inc(0.2)
// app.nprogress.done()
// Component:
// this.$nprogress
```


## Configuration

```js
const options = {
  latencyThreshold: 200, // Nombre de ms avant le début de la barre de progression, par défaut c'est: 100,
  router: true, // Afficher la barre de progression lors de la navigation, les routes par défaut sont à: true
  http: false // Afficher la barre de progression lorsque vous effectuez Vue.http, par défaut c'est: true
};
Vue.use(NProgress, options)
```

Pour remplacer la configuration de certaines requêtes, utilisez le paramètre showProgressBar dans la méta de request/route.

Comme celui-ci:

```js
Vue.http.get('/url', { showProgressBar: false })
```
```js
const router = new VueRouter({
  routes: [
    {
      path: '/foo',
      component: Foo,
      meta: {
        showProgressBar: false
      }
    }
  ]
})
```


## Badges

![](https://img.shields.io/badge/license-MIT-blue.svg)
![](https://img.shields.io/badge/status-stable-green.svg)

---

> [medlib.fr](https://medlib.fr) &nbsp;&middot;&nbsp;
> GitHub [@medlib](https://github.com/medlib-v2) &nbsp;&middot;&nbsp;
> Twitter [@medlib](https://twitter.com/medlib)

