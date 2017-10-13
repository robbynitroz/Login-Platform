<template>

    <div class="vertical-center" :style="background(false)">

        <div class="container justify-content-center  row">

            <div :style="background(true)" class="login col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">

                <a :style="{ float:'right', fontSize:policy.size, margin:'3% 0 0 0', color:policy.color }" href="#">
                    {{ policy.text | capitalize }} </a>

                <div class="clearfix"></div>







                <div class="col-xs-12 text-center">
                    <img class="img-fluid logo-image" :src="hotelLogo"/>
                </div>

            </div>
        </div>

    </div>


</template>

<script>
    import {windowSize} from '../mixins/windowSize';
    import {mapGetters} from 'vuex';


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

            ]),

            buttonStyleObject() {
                var modifier = '';
                if (this.button.hoverState)
                    modifier = 'Hover';

                return {
                    color: this.button['color' + modifier],
                    backgroundColor: this.button['colorBackd' + modifier],
                    borderColor: this.button['borderColor' + modifier]
                };
            },

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


            checkUserLang(userLang){
                console.log(userLang);
            }


        },

        mounted() {
            this.$nextTick(function () {
                let userLang = navigator.language || navigator.userLanguage;
                this.checkUserLang(userLang);
            })
        },

        mixins: [windowSize],


    }
</script>

<style scoped>


    .vertical-center {
        margin-bottom: 0; /* Remove the default bottom margin of .jumbotron */
    }

    .middle {
        margin-top: 15%;
    }

    .greetings {
        margin-top: 20%;
        margin-bottom: 25px;

    }

    .large-button {

        width: 70%;
        height: 50px;
        margin: 15%;
    }

    .fa {
        padding-left: 5%;
    }

    @media screen and (max-width: 576px) {
        .container {
            min-height: 100%; /* Fallback for vh unit */
            min-height: 100vh;

        }

        .large-button {

            margin: 8%;

        }

        .message {
            margin-bottom: 15%;
        }

        .greetings {
            margin-top: 20%;
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
