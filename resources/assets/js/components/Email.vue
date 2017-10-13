<template>

    <div class="vertical-center" :style="background(false)">

        <div class="container justify-content-center  row">

            <div :style="background(true)" class="login col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">

                <a :style="{ float:'right', fontSize:policy.size, margin:'3% 0 0 0', color:policy.color }" href="#"
                   @click="changeToPolicy"
                >
                    {{ texts[defaultLanguage].policyLinkText | capitalize }} </a>

                <div class="clearfix"></div>

                <h1 v-if="greetingsTime.on" :style="{ color:greetingsTime.color, fontSize:greetingsTime.size}"
                    class="text-center greetings"> {{ sayTime }}</h1>


                <h2 class="text-center message"
                    :style="{ color:greeting.color, fontSize:greeting.size, wordWrap:'break-word'}">
                    {{ texts[defaultLanguage].greetingText }} </h2>

                <!--Here-->
                <div class="col-xs-12 text-center button align-items-center justify-content-center">


                    <div class="form-group middle dimensions">
                        <input type="email" required class="form-control form-control-lg" id="formGroupExampleInput"
                               :placeholder="texts[defaultLanguage].emailText">
                    </div>


                    <button type="submit"
                            :style="buttonStyleObject"
                            @mouseenter='updateHoverState(true)'
                            @mouseleave="updateHoverState(false)"
                            @click='sendEmailToServer'
                            class="btn btn-outline-info large-button text-center"> {{ texts[defaultLanguage].buttonText
                        }}   <i
                                :style="{color:buttonIcon.color}" :class="['fa',buttonIcon.class]"
                                aria-hidden="true"></i>
                    </button>
                </div>
                <!--Here-->


                <div class="col-xs-12 text-center">
                    <img class="img-fluid logo-image" :src="hotelLogo"/>
                </div>

            </div>
        </div>

    </div>


</template>

<script>
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    import {languageDetection} from '../mixins/languageDetection';
    import {windowSize} from '../mixins/windowSize';
    import {auth} from '../mixins/auth';


    export default {

        name: 'appEmail',
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
            sayTime() {
                let today = new Date()
                let curHr = today.getHours()

                if (curHr < 12) {
                    return 'Good morning!';
                } else if (curHr < 18) {
                    return 'Good afternoon!';
                } else {
                    return 'Good evening!'
                }
            },

            ...mapGetters([
                'hotelLogo',
                'texts',
                'policy',
                'greetingsTime',
                'greeting',
                'button',
                'buttonIcon',

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

            ...mapActions([
                'updateActiveComponent'

            ]),

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

            updateHoverState(isHover) {
                this.button.hoverState = isHover;
            },

            changeToPolicy() {
                this.$store.dispatch('updateActiveComponent', 'app-policy');
            }


        },

        mixins: [
            windowSize,
            auth,
            languageDetection
        ],


    }
</script>

<style scoped>


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
        margin-bottom: 10%;
        margin-top: 5%;

    }

    .dimensions {
        width: 85%;
        margin-left: 8%;

    }

    ::-webkit-input-placeholder {
        text-align: center;
    }

    :-moz-placeholder { /* Firefox 18- */
        text-align: center;
    }

    ::-moz-placeholder { /* Firefox 19+ */
        text-align: center;
    }

    :-ms-input-placeholder {
        text-align: center;
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

        .dimensions {
            width: 100%;
            margin-left: 0%;

        }

    }

    @media screen and (min-width: 576px) {
        .login {
            border-radius: 5px;
        }
    }


</style>
