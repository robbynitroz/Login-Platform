<template>
    <div class="container-fluid">
        <comment :is="defaultComponent"></comment>
    </div>

</template>

<script>


    import Feeds from './Feeds';
    export default {
        name: 'MainPage',
        data() {
            return {
                defaultComponent:'feeds',
            }
        },

        components: {
            Feeds,
        },

        computed: {

        },

        methods:{

        }

    }
</script>

<style scoped>


</style>