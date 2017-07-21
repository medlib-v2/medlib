<template lang="html">
    <div class="main-content">
        <main id="content" class="error-container" role="main">
            <section class="error-container">
                <div class="error-number">404</div>
                <div class="error-description">Opps, il semble que cette page n'existe pas.</div>
                <div class="error-goback-text">Would you like to go home?</div>
                <div class="error-goback-button">
                    <router-link :to="{ name: 'home', exact: true }" class="btn btn-xl btn-primary">Let's go home</router-link>
                </div>
            </section>
        </main>
    </div>
</template>

<script type="text/babel">
    export default {
        head: {
            title: {
                inner: 'Page Not Found'
            },
            meta: [
                // ...
            ]
        }
    };
</script>
