# Modals

>  Modals are streamlined, but flexible dialog prompts powered by JavaScript.
  They support a number of use cases from user notification to completely custom content and feature
  a handful of helpful sub-components, sizes, and more.

Other elements can easily show modals using `v-modal` directive.

```html
    <!-- Using modifiers --> 
    <b-button v-modal.modal1>Show Modal</b-button>
    
    <!-- Using value --> 
    <b-button v-modal="'modal1'">Show Modal</b-button>
    
    <button @click="$root.$emit('show::modal','modal1')">Show Modal</button>
```

### Example ###
```vue
<template lang="html">
  <div id="app">
      <b-btn v-b-modal.modal1>Launch demo modal</b-btn>
  
      <!-- Main UI -->
      <div class="mt-3 mb-3">
          Submitted Names:
          <ul>
              <li v-for="n in names">{{n}}</li>
          </ul>
      </div>
  
      <!-- Modal Component -->
      <b-modal id="modal1" title="Submit your name" @ok="submit" @shown="clearName">
  
          <form @submit.stop.prevent="submit">
              <b-form-input type="text" placeholder="Enter your name" v-model="name"></b-form-input>
          </form>
  
      </b-modal>
  
  </div>
</template>

<script type="text/babel">
export default {
    data: {
        name: '',
        names: []
    },
    methods: {
        clearName() {
            this.name = '';
        },
        submit() {
            if (!this.name) {
                /* eslint-disable no-alert */
                alert('Please enter your name');
                return false;
            }
            this.names.push(this.name);
            this.name = '';
            // Ensure modal closes
            this.$root.$emit('hide::modal', 'modal1');
        }
    }
};
</script>
```

## Properties
Property        | Type          | Default Value
--------------- | ------------- | ------------
id              | `String`      | 
title           | `String`      | 
size            | `String`      | `md`
fade            | `Boolean`     | `true`
zoom            | `Boolean`     | `false`
close-title     | `String`      | `Close`
ok-title        | `String`      | `OK`
close-on-backdrop| `Boolean`    | `true`
show-header     | `Boolean`     | `false`
show-footer     | `Boolean`     | `true`

## Slots
Slot            | Description
--------------- | -------------
modal-header    | Entire modal header container
modal-title     | Modal title
modal-footer    | Modal footer content

## Events
Event           | Arguments     | Description
--------------- | ------------- | ------------
shown           |               | always emits when modal is shown
hidden          |               | always emits when modal is hidden
ok              |               | when default ok button pressed
cancel          |               | when default cancel button pressed 