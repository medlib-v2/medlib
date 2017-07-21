<template lang="html">
    <main id="content" class="content" role="main">
        <section class="user-settings">
            <div class="row">
                <!-- Beginning Menu Navigation Settings -->
                <div class="col-xs-12 col-sm-5 col-md-3">
                    <MenuSetting />
                </div>
                <!-- Ending Menu Navigation Settings -->
                <!-- Beginning content -->
                <div class="boxed-group col-xs-12 col-sm-7 col-md-9">
                    <router-view></router-view>
                </div>
                <!-- Ending content -->
            </div>
        </section>
    </main>
</template>

<script type="text/babel">
    import MenuSetting from '../components/MenuSetting.vue'

    export default {
        components: {
            MenuSetting
        },

        head: {
            title: {
                inner: 'Setting'
            },
            meta: [
                // ...
            ]
        }
    };
</script>
