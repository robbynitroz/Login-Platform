<template>

    <div class="vertical-center" :style="background(false)">

        <div class="container justify-content-center  row">

            <div :style="background(true)" class="login col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">

                <a :style="{ float:'right', fontSize:policy.size, margin:'3% 0 0 0', color:policy.color }" href="#"
                   @click="changeBackToDefault"
                >
                    {{ texts[defaultLanguage].policyBackLinkText | capitalize }} </a>
                <div class="clearfix"></div>

                <div :style="{color:policy.color }" class="text-center middle" v-html="texts[defaultLanguage].policyText"></div>

                <a :style="{ float:'right', fontSize:policy.size, margin:'3% 0 0 0', color:policy.color }" href="#"
                   @click="changeBackToDefault"
                >
                    {{ texts[defaultLanguage].policyBackLinkText | capitalize }} </a>


                <div class="col-xs-12 text-center">
                    <img class="img-fluid logo-image" :src="hotelLogo"/>
                </div>

            </div>
        </div>

    </div>


</template>

<script>
    import {mapGetters} from 'vuex';
    import {languageDetection} from '../../mixins/languageDetection';
    import {windowSize} from '../../mixins/windowSize';

    export default {

        name: 'appPolicy',
        data() {
            return {}
        },

        filters: {
            capitalize: function (value) {
                if (!value) return ''
                value = value.toString()
                return value.toUpperCase();
            }
        },

        computed: {

            ...mapGetters([
                'hotelLogo',
                'texts',
                'policy',
                'defaultComponent',

            ]),

        },

        methods: {
            // whenever the document is resized, re-set the 'fullHeight' variable
            background(param) {
                if (param == false) {
                    if (this.windowWidth < 576) {
                        return this.$store.getters.backgroundColor
                    } else {
                        return false
                    }
                }
                if (param == true) {
                    if (this.windowWidth > 576) {
                        return this.$store.getters.backgroundColor
                    } else {
                        return false
                    }
                }
            },

            changeBackToDefault() {
                this.$store.dispatch('updateActiveComponent', this.defaultComponent);
            },

        },

        mixins: [
            windowSize,
            languageDetection
        ],

    }
</script>

<style scoped>

    .vertical-center {
        margin-bottom: 0; /* Remove the default bottom margin of .jumbotron */
    }

    .middle {
        margin-top: 15%;
        margin-bottom: 25px;
    }

    @media screen and (max-width: 576px) {
        .container {
            min-height: 100%; /* Fallback for vh unit */
            min-height: 100vh;

        }

        .logo-image {
            margin-top: 25px;
        }

        .row {
            margin: 0;
        }

    }

    @media screen and (min-width: 576px) {
        .login {
            border-radius: 5px;
        }
    }

</style>
