<template>
    <div>
        {{ svg_content }}
    </div>
</template>
<script type="text/babel">
export default{
    props: ['src'],
    data() {
        return {
            svg_content:''
        }
    },
    created() {
        this.$http.get(this.src, {'Content-Type': 'application/xml'}).then((response) => {
            console.log('svg response', response)
        })
    }
}
</script>
