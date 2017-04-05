// http://eslint.org/docs/user-guide/configuring

module.exports = {
    root: true,
    parser: 'babel-eslint',
    parserOptions: {
        sourceType: 'module'
    },
    env: {
        browser: true,
        node: true
    },
    // https://github.com/feross/standard/blob/master/RULES.md#javascript-standard-style
    extends: 'standard',
    // required to lint *.vue files
    plugins: [
        'html'
    ],
    // add your custom rules here
    'rules': {
        'arrow-parens': 0,
        'array-bracket-even-spacing': 0,
        'computed-property-even-spacing': 0,
        // allow async-await
        'camelcase': 0,
        'generator-star-spacing': 0,
        'one-var': 0,
        'semi':0,
        'semi-spacing': ['error', { 'before': false, 'after': true }],
        'space-before-blocks': ['error', 'always'],
        'space-before-function-paren': 0,
        'space-in-parens': ['error', 'never'],
        'no-extra-bind': 0,
        'no-extra-semi': 'error',
        'no-proto': 0,
        'no-new': 0,
        'no-return-assign': 0,
        'no-debugger': process.env.NODE_ENV === 'production' ? 2 : 0,
        'wrap-iife': 0,
        'eol-last': 0,
        'indent': [2, 2],
        'quotes': [2, 'single'],
    }
}
