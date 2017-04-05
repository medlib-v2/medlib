<template lang="html">
    <div class="error-content-wrapper">
        <div class="error-content">
            <div class="box-error">
                <h1>404</h1>
                <h4>Désoler - {{ message }}!</h4>
                <p>Le livre que vous cherchez à consulter n'est pas disponible. :(</p>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
export default {
    data () {
        return {
            message:'Le livre n\'a pas été trouvé'
        }
    }
}
</script>
