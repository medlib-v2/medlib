<template lang="html">
    <ul class="nav navbar-nav be-navbar-toggle hidden-xs">
        <li>
            <div class="main">
                <form novalidate="novalidate" onsubmit="return false;" :class="getFormClass">
                    <div role="search" :class="getClassWrapper">
                        <input type="search" name="search" :placeholder="getPlaceholder" autocomplete="off" required="required" :class="getClassInputPlaceholder">
                        <input :disabled="disabled" @click="emitClickInput" @keyup='changeText' v-model='textVal' type="search" :name="name" placeholder="" autocomplete="off" required="required" :class="getClassInput" :autofocus="autofocus">
                        <button @click="emitClickButton" type="submit" :class="getClassSubmit">
                            <svg role="img" aria-label="Search">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" :xlink:href="getSVGSearch"></use>
                            </svg>
                        </button>
                        <button @click="reset" type="reset" :class="getClassReset">
                            <svg role="img" aria-label="Reset">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" :xlink:href="getSVGClear"></use>
                            </svg>
                        </button>
                        <div v-if="modeIsFull" class='el-input-group__append'>
                            <ul v-on-clickaway="away" v-if="suggestionsIsVisible && showSuggestions" class="be-el-search__suggestions">
                                <li @click="selectedAction(index)" v-for="(item, index) in similiarData" :class="getClassHighlighted(index)">{{item[suggestionAttribute]}}</li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" style="display:none">
                <symbol xmlns="http://www.w3.org/2000/svg" id="sbx-icon-search-8" viewBox="0 0 40 40">
                    <path d="M16 32c8.835 0 16-7.165 16-16 0-8.837-7.165-16-16-16C7.162 0 0 7.163 0 16c0 8.835 7.163 16 16 16zm0-5.76c5.654 0 10.24-4.586 10.24-10.24 0-5.656-4.586-10.24-10.24-10.24-5.656 0-10.24 4.584-10.24 10.24 0 5.654 4.584 10.24 10.24 10.24zM28.156 32.8c-1.282-1.282-1.278-3.363.002-4.643 1.282-1.284 3.365-1.28 4.642-.003l6.238 6.238c1.282 1.282 1.278 3.363-.002 4.643-1.283 1.283-3.366 1.28-4.643.002l-6.238-6.238z"
                          fill-rule="evenodd" />
                </symbol>
                <symbol xmlns="http://www.w3.org/2000/svg" id="sbx-icon-clear-4" viewBox="0 0 20 20">
                    <path d="M11.664 9.877l4.485 4.485-1.542 1.54-4.485-4.485-4.485 4.485-1.54-1.54 4.485-4.485-4.485-4.485 1.54-1.54 4.485 4.484 4.485-4.485 1.54 1.542-4.484 4.485zM10 20c5.523 0 10-4.477 10-10S15.523 0 10 0 0 4.477 0 10s4.477 10 10 10z" fill-rule="evenodd"
                    />
                </symbol>
            </svg>
        </li>
    </ul>
</template>

<script type="text/babel">
    import { mixin as clickaway } from '../mixins/clickaway'
    import { event } from '../utils'

    export default {
        name: 'el-search',
        mixins: [ clickaway ],
        props: {
            'value': {
                type: String,
                required: true
            },
            'suggestions': {
                type: Array,
                required: true
            },
            'suggestionAttribute': {
                type: String,
                required: true
            },
            'placeholder': {
                type: String,
                default: 'write something...'
            },
            'minMatch': {
                type: Number,
                default: 2
            },
            'name': {
                type: String,
                default: 'vueInstant'
            },
            'autofocus': {
                type: Boolean,
                default: true
            },
            'disabled': {
                type: Boolean
            },
            'type': {
                type: String,
                default: 'facebook'
            },
            'showAutocomplete': {
                type: Boolean,
                default: true
            }
        },
        data () {
            return {
                selectedEvent: null,
                selectedSuggest: null,
                inputChanged: false,
                suggestionsIsVisible: true,
                highlightedIndex: 0,
                highlightedIndexMax: 7,
                textVal: this.value,
                similiarData: [],
                placeholderVal: this.placeholder,
                types: [
                    {
                        name: 'facebook',
                        formClass: 'searchbox sbx-facebook',
                        classWrapper: 'sbx-facebook__wrapper',
                        classInput: 'sbx-facebook__input',
                        classInputPlaceholder: 'sbx-facebook__input-placeholder',
                        classSubmit: 'sbx-facebook__submit',
                        svgSearch: '#sbx-icon-search-8',
                        classReset: 'sbx-facebook__reset',
                        svgClear: '#sbx-icon-clear-4',
                        highlighClass: 'highlighted__facebook'
                    },
                    {
                        name: 'google',
                        formClass: 'searchbox sbx-google',
                        classWrapper: 'sbx-google__wrapper',
                      classInput: 'sbx-google__input',
                      classInputPlaceholder: 'sbx-google__input-placeholder',
                      classSubmit: 'sbx-google__submit',
                      svgSearch: '#sbx-icon-search-8',
                      classReset: 'sbx-google__reset',
                      svgClear: '#sbx-icon-clear-4',
                      highlighClass: 'highlighted__google'
                    },
                    {
                      name: 'amazon',
                      formClass: 'searchbox sbx-amazon',
                      classWrapper: 'sbx-amazon__wrapper',
                      classInput: 'sbx-amazon__input',
                      classInputPlaceholder: 'sbx-amazon__input-placeholder',
                      classSubmit: 'sbx-amazon__submit',
                      svgSearch: '#sbx-icon-search-8',
                      classReset: 'sbx-amazon__reset',
                      svgClear: '#sbx-icon-clear-4',
                      highlighClass: 'highlighted__amazon'
                    },
                    {
                      name: 'twitter',
                      formClass: 'searchbox sbx-twitter',
                      classWrapper: 'sbx-twitter__wrapper',
                      classInput: 'sbx-twitter__input',
                      classInputPlaceholder: 'sbx-twitter__input-placeholder',
                      classSubmit: 'sbx-twitter__submit',
                      svgSearch: '#sbx-icon-search-8',
                      classReset: 'sbx-twitter__reset',
                      svgClear: '#sbx-icon-clear-4',
                      highlighClass: 'highlighted__twitter'
                    },
                    {
                      name: 'spotify',
                      formClass: 'searchbox sbx-spotify',
                      classWrapper: 'sbx-spotify__wrapper',
                      classInput: 'sbx-spotify__input',
                      classInputPlaceholder: 'sbx-spotify__input-placeholder',
                      classSubmit: 'sbx-spotify__submit',
                      svgSearch: '#sbx-icon-search-8',
                      classReset: 'sbx-spotify__reset',
                      svgClear: '#sbx-icon-clear-4',
                      highlighClass: 'highlighted__spotify'
                    },
                    {
                      name: 'custom',
                      formClass: 'searchbox sbx-custom',
                      classWrapper: 'sbx-custom__wrapper',
                      classInput: 'sbx-custom__input',
                      classInputPlaceholder: 'sbx-custom__input-placeholder',
                      classSubmit: 'sbx-custom__submit',
                      svgSearch: '#sbx-icon-search-8',
                      classReset: 'sbx-custom__reset',
                      svgClear: '#sbx-icon-clear-4',
                      highlighClass: 'highlighted__custom'
                    }
                ]
            }
        },
        computed: {
          getPlaceholder () {
            if (this.inputChanged || this.textValIsEmpty()) {
              return this.placeholderVal
            }
          },
          modeIsFull () {
            return this.showAutocomplete
          },
          showSuggestions () {
            return this.similiarData.length >= this.minMatch
          },
          getPropertiesClass () {
            let type = this.getType()
            return type.properties
          },
          getFormClass () {
            let type = this.getType()
            return type.formClass
          },
          getClassWrapper () {
            let type = this.getType()
            return type.classWrapper
          },
          getClassInput () {
            let type = this.getType()
            return type.classInput
          },
          getClassInputPlaceholder () {
            let type = this.getType()
            return type.classInputPlaceholder
          },
          getClassSubmit () {
            let type = this.getType()
            return type.classSubmit
          },
          getSVGSearch () {
            let type = this.getType()
            return type.svgSearch
          },
          getClassReset () {
            let type = this.getType()
            return type.classReset
          },
          getSVGClear () {
            let type = this.getType()
            return type.svgClear
          }
        },
        methods: {
          decrementHighlightedIndex () {
            this.highlightedIndex -= 1
          },
          incrementHighlightedIndex () {
            this.highlightedIndex += 1
          },
          escapeAction () {
            this.clearHighlightedIndex()
            this.clearSimilarData()
            this.clearSelected()
            this.setBlur()
            this.emitEscape()
          },
          arrowRightAction () {
            this.setPlaceholderAndTextVal()
            this.emitKeyRight()
          },
          arrowDownAction () {
            if (this.arrowDownValidation()) {
              this.incrementHighlightedIndex()
              this.setPlaceholderAndTextVal()
              this.emitKeyDown()
            } else {
              this.clearHighlightedIndex()
            }
          },
          arrowUpAction () {
            if (this.highlightedIndex > 0) {
              this.decrementHighlightedIndex()
              this.setPlaceholderAndTextVal()
              this.emitKeyUp()
            } else {
              this.clearHighlightedIndex()
            }
          },
          enterAction () {
            this.setFinalTextValue()
            this.clearHighlightedIndex()
            this.clearSimilarData()
            this.emitEnter()
          },
          selectedAction (index) {
            this.highlightedIndex = index
            this.setFinalTextValue()
            this.clearPlaceholder()
            this.clearSimilarData()
            this.emitSelected()
          },
          addRegister (o) {
            if (this.isSimilar(o) && this.textValIsNotEmpty()) {
              this.addSuggestion(o)
            }
          },
          addSuggestion (o) {
            if (!this.findSuggestionTextIsRepited(o)) {
              this.addToSimilarData(o)
            }
          },
          addToSimilarData (o) {
            if (this.canAddToSimilarData()) {
              this.placeholderVal = this.letterProcess(o)
              this.selectedSuggest = o
              this.emitSelected()
              this.similiarData.unshift(o)
            }
          },
          setTextValue (e) {
            if (e.target.value.trim()) {
              this.textVal = e.target.value
              this.emitChange()
            }
          },
          setSelectedAsTextValue () {
            this.textVal = this.selected
          },
          setInitialTextValue () {
            this.textVal = this.value
          },
          setFinalTextValue () {
            if (this.finalTextValueValidation()) {
              this.setPlaceholderAndTextVal()
              this.emitChange()
            } else {
              this.clearAll()
            }
          },
          setPlaceholderAndTextVal () {
            if (typeof this.similiarData[this.highlightedIndex] !== 'undefined') {
              let suggest = this.similiarData[this.highlightedIndex]
              this.placeholderVal = suggest[this.suggestionAttribute]
              this.textVal = suggest[this.suggestionAttribute]
              this.selectedSuggest = suggest
              this.emitSelected()
            }
          },
          setInitialPlaceholder () {
            this.placeholderVal = this.placeholder
          },
          setBlur () {
            this.$el.blur()
          },
          getType () {
            return this.types.find(this.isSameType)
          },
          getClassHighlighted (index) {
            if (this.highlightedIndex === index) {
              let type = this.getType()
              return type.highlighClass
            }
          },
          letterProcess (o) {
            let remoteText = o[this.suggestionAttribute].split('')
            let inputText = this.textVal.split('')
            inputText.forEach(function (letter, key) {
              if (letter !== remoteText[key]) {
                remoteText[key] = letter
              }
            })
            return remoteText.join('')
          },
          findSuggests () {
            if (this.suggestionsPropIsDefined()) {
              this.suggestions.forEach(this.addRegister)
            }
          },
          arrowDownValidation () {
            return this.highlightedIndex < this.highlightedIndexMax &&
                   this.highlightedIndex < (this.similiarData.length - 1)
          },
          lowerFirst (string) {
            return string.charAt(0).toLowerCase() + string.slice(1)
          },
          controlEvents () {
            let uncaptz = this.lowerFirst(this.selectedEvent + 'Action')
            let fnName = (this[uncaptz])
            if (this.fnExists(fnName)) {
              fnName()
            }
          },
          findRepited (similarItem, o) {
            return (similarItem[this.suggestionAttribute] ===
            o[this.suggestionAttribute])
          },
          findSuggestionTextIsRepited (o) {
            return this.similiarData.find(this.findRepited.bind(this, o))
          },
          finalTextValueValidation () {
            return typeof this.similiarData[this.highlightedIndex] !== 'undefined' ||
                this.placeholderVal === '' && this.highlightedIndex !== 0
          },
          isSimilar (o) {
            if (o) {
              return o[this.suggestionAttribute]
                      .toLowerCase()
                      .startsWith(this.textVal.toLowerCase())
            }
          },
          isSameType (o) {
            return o.name === this.type
          },
          fnExists (fnName) {
            return typeof fnName === 'function'
          },
          canAddToSimilarData () {
            return this.similiarData.length < this.highlightedIndexMax
          },
          suggestionsPropIsDefined () {
            return typeof this.suggestions !== 'undefined'
          },
          notArrowKeysEvent () {
            return this.selectedEvent !== 'ArrowUp' &&
                    this.selectedEvent !== 'ArrowDown' && this.selectedEvent !== 'ArrowRight'
          },
          notEnterKeyEvent () {
            return this.selectedEvent !== 'Enter'
          },
          textValIsEmpty () {
            return this.textVal === ''
          },
          textValIsNotEmpty () {
            return this.textVal !== ''
          },
          reset () {
            this.clearValue()
            this.clearSelected()
            this.clearPlaceholder()
            this.clearSimilarData()
            this.clearSelectedSuggest()
            this.emitClear()
            this.emitSelected()
          },
          clearAll () {
            this.clearSelected()
            this.clearPlaceholder()
            this.clearSimilarData()
            this.clearSelectedSuggest()
          },
          clearValue () {
            this.textVal = ''
          },
          clearSelected () {
            this.selected = null
          },
          clearSelectedSuggest () {
            this.selectedSuggest = null
          },
          clearSimilarData () {
            this.similiarData = []
          },
          clearPlaceholder () {
            if (this.textValIsEmpty()) {
              this.clearSimilarData()
              this.setInitialPlaceholder()
            } else {
              this.placeholderVal = ''
            }
          },
          clearHighlightedIndex () {
            this.highlightedIndex = 0
          },
          changeText (e) {
            this.selectedEvent = e.code
            this.setTextValue(e)
            this.processChangeText()
            this.controlEvents(e)
          },
          processChangeText (e) {
            if (this.notEnterKeyEvent()) {
              this.inputChanged = true
              this.suggestionsIsVisible = true
              this.clearAllAndFindSuggest()
            }
          },
          clearAllAndFindSuggest () {
            if (this.notArrowKeysEvent()) {
              this.clearAll()
              this.findSuggests()
            }
          },
          away () {
            this.suggestionsIsVisible = false
            this.emitSelected()
          },
          emitChange () {
            event.emit('input', this.textVal)
          },
          emitClickInput (e) {
            event.emit('click-input', e)
          },
          emitClickButton (event) {
            event.emit('click-button', this.textVal)
          },
          emitEnter () {
            event.emit('enter')
          },
          emitKeyUp () {
            event.emit('key-up')
          },
          emitKeyDown () {
            event.emit('key-down', this.selectedSuggest)
          },
          emitKeyRight () {
            event.emit('key-right')
          },
          emitClear () {
            event.emit('clear')
          },
          emitEscape () {
            event.emit('escape')
          },
          emitSelected () {
            event.emit('selected', this.selectedSuggest)
          }
        }
    }
</script>
