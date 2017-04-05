reCAPTCHA
=============

## Description ##
Google ReCAPTCHA component for vue.

## Usage ##

### General ###
Place this in head to load reCAPTCHA:
```html
<script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer>
</script>
```
```
With `onload` callback, it will notify us when the api is ready for use.
```

### Normal ReCAPTCHA ###
```vue
<template lang="html">
  <recaptcha sitekey="Your key here"></recaptcha>
</template>

<script type="text/babel">
  import Recaptcha from '../plugins/Recaptcha';
  export default {
    ...
    components: { Recaptcha }
  };
</script>
```

### Bind Challenge to Button ###
```vue
<template lang="html">
  <recaptcha sitekey="Your key here">
    <button>Click me</button>
  </recaptcha>
</template>

<script type="text/babel">
  import Recaptcha from '../plugins/Recaptcha';
  export default {
    ...
    components: { Recaptcha }
  };
</script>
```

**Notice:** You could only place one element as `recaptcha` child.

For more information, please reference to [example](example)

## API ##

### Props ###
- sitekey (required)  
  ReCAPTCHA site key
- theme (optional)  
  The color theme for reCAPTCHA
- type (optional)  
  The type of reCAPTCHA
- size (optional)  
  The size of reCAPTCHA
- tabindex (optional)  
  The tabindex of reCAPTCHA
- badge (optional) (Invisible ReCAPTCHA only)  
  Position of the reCAPTCHA badge

### Methods ###
- reset  
  Reset reCAPTCHA instance
- execute  
  Invoke reCAPTCHA challenge
  
[example]: https://github.com/DanSnow/vue-recaptcha/tree/master/example
[recaptcha-params]: https://developers.google.com/recaptcha/docs/display#render_param
[invisible-recaptcha-params]: https://developers.google.com/recaptcha/docs/invisible#render_param