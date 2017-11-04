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
                <div v-if="loadingBar" class="loader"></div>
                <div class="col-xs-12 text-center button align-items-center justify-content-center">
                    <button @click="sendToServer"
                            v-show="!loadingBar"
                            type="button"
                            :style="buttonStyleObject"
                            @mouseenter='updateHoverState(true)'
                            @mouseleave="updateHoverState(false)"
                            class="btn btn-outline-info large-button text-center"> {{ texts[defaultLanguage].buttonText }}
                    </button>
                </div>
                <!--Here-->
                <p :style="{ color:littleTextColor.color }" class="text-center"><i> {{ littleTextColor.text }} </i></p>


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
    import {languageDetection} from '../../mixins/languageDetection';
    import {windowSize} from '../../mixins/windowSize';


    export default {

        name: 'appLogin',
        data() {
            return {
                loader: false
            }
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
                    return this.texts[this.defaultLanguage].sayTimeMorning;
                } else if (curHr < 18) {
                    return this.texts[this.defaultLanguage].sayTimeAfternoon;
                } else {
                    return this.texts[this.defaultLanguage].sayTimeEvening;
                }
            },

            loadingBar() {
                return this.loader;
            },

            ...mapGetters([
                'hotelLogo',
                'texts',
                'policy',
                'greetingsTime',
                'greeting',
                'button',
                'buttonIcon',
                'littleTextColor'

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

            changeToPolicy(){
                this.$store.dispatch('updateActiveComponent', 'app-policy');
            },


            sendToServer() {

                let config = {
                    onUploadProgress: progressEvent => {
                        this.changeLoaderStatus();
                    }
                };

                let hotelID = document.head.querySelector('meta[name="hotel"]');
                let hotelURL = document.head.querySelector('meta[name="hotel-url"]');
                let clientMac = document.head.querySelector('meta[name="mac-address"]');
                let loginMethod = document.head.querySelector('meta[name="login-method"]');
                axios.post('/auth/login',
                    {
                        hotel_url:hotelURL.content,
                        hotel_id:hotelID.content,
                        mac_address:clientMac.content,
                        login_type:loginMethod.content
                    },
                    config)
                    .then(response => {
                        document.location.href =response.data;
                        this.changeLoaderStatus()
                    })
                    .catch(e => {
                        console.log(e)
                        this.changeLoaderStatus()
                    })
            }




        },

        mixins: [
            windowSize,
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
        margin: 15%;
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

    .loader {
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 100px;
        height: 100px;
        animation: spin 0.2s linear infinite;
        position: absolute;
        left: 38%;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

</style>
