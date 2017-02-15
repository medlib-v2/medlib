<template lang="html">
    <div class="be-spinner" v-show="loading">
        <div class="be-beat be-beat-odd" :style="spinnerStyle">
        </div><div class="be-beat be-beat-even" :style="spinnerStyle">
    </div><div class="be-beat be-beat-odd" :style="spinnerStyle">
    </div>
    </div>
</template>

<script type="text/babel">
export default {
  name: 'beat-loader',
  props: {
    loading: {
      type: Boolean,
      default: true
    },
    color: {
      type: String,
      default: '#5dc596'
    },
    size: {
      type: String,
      default: '10px'
    },
    margin: {
      type: String,
      default: '2px'
    },
    radius: {
      type: String,
      default: '100%'
    }
  },
  data () {
    return {
      spinnerStyle: {
        backgroundColor: this.color,
        height: this.size,
        width: this.size,
        margin: this.margin,
        borderRadius: this.radius
      }
    }
  }
}
</script>
