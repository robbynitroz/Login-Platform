<template>
    <div v-if="notEmpty">
        <b-card-group columns>
            <template v-for="feed in feeds">
                <b-card
                        :title="feed.title"
                        :img-src="feed.img"
                        img-fluid
                        :img-alt="feed.title"
                        img-top>
                    <template v-html="feed.text"></template>
                </b-card>
            </template>
        </b-card-group>
    </div>
</template>

<script>
    export default {
        name: "Feeds",
        data() {
            return {
                feeds: {},
                error: false,
            }
        },

        mounted() {
            let path = this.$route.path;
            axios.get('/newsfeeds' + path)
                .then(response => {
                    this.feeds = response.data;
                })
                .catch(e => {
                    this.error = true;
                });
        },

        computed:{
            notEmpty(){

                if(this.feeds.length >= 1 && (typeof this.feeds) === 'object'){
                    return true
                }
                return false
            },
        },

        methods:{

        }

    }
</script>

<style scoped>

</style>