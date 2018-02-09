<template>
    <div class="vertical-center" :style="background(false)">
        <div id="fb-root"></div>
        <div class="container justify-content-center  row">
            <div :style="background(true)" class="login col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                <a :style="{ float:'right', fontSize:policy.size, margin:'3% 0 0 0', color:policy.color }" href="#"
                   @click="changeToPolicy"
                >
                    {{ texts[defaultLanguage].policyLinkText | capitalize }} </a>
                <div class="clearfix"></div>
                <h1 v-if="greetingsTime.on" :style="{ color:greetingsTime.color, fontSize:greetingsTime.size}"
                    class="text-center greetings"> {{ sayTime }}</h1>
                <div v-else class="clearfix greetings"></div>
                <h2 class="text-center message"
                    :style="{ color:greeting.color, fontSize:greeting.size, wordWrap:'break-word'}">
                    {{ texts[defaultLanguage].greetingText }} </h2>
                <!--Here-->
                <div v-if="loadingBar" class="loader"></div>
                <div class="col-xs-12 text-center button align-items-center justify-content-center">
                    <div v-if="showLikeButton"  class="col-12 little-down"></div>
                    <div v-show="showLikeButton" class="fb-like" :data-href="facebookURL" data-layout="button" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>
                    <div v-show="showLikeButton"  class="clearfix"></div>
                    <form v-if="showEmailMethod" @submit.prevent="sendToServer('email')" action="#" method="post">
                        <div class="form-group middle dimensions">
                            <div v-if="requireName" class="form-row full-name">
                                <div class="col">
                                    <input v-model="userName" type="text" class="form-control" placeholder="First name">
                                </div>
                                <div class="col">
                                    <input v-model="userLastName" type="text" class="form-control"
                                           placeholder="Last name">
                                </div>
                            </div>
                            <input v-model="userEmail" type="email" class="form-control form-control-lg"
                                   id="formGroupExampleInput"
                                   :placeholder="texts[defaultLanguage].emailText">
                        </div>
                        <button v-show="!loadingBar"
                                type="submit"
                                :style="buttonStyleObject"
                                @mouseenter='updateHoverState(true)'
                                @mouseleave="updateHoverState(false)"
                                class="btn btn-outline-info large-button text-center">
                            {{ texts[defaultLanguage].buttonText
                            }}
                        </button>
                    </form>
                    <button v-if="!showLikeButton"
                            @click="FBlogin"
                            class="loginBtn loginBtn--facebook text-center">
                        {{ showFBButtonText }}
                    </button>
                    <template v-if="requireEmail">
                    <button v-if="!showEmailMethod"
                            v-show="!showLikeButton"
                            @click="showEmail"
                            class="loginBtn loginBtn--google text-center">
                        {{ showEmailButtonText }}
                    </button>
                    </template>
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
    import {languageDetection} from '../../mixins/languageDetection';
    import {windowSize} from '../../mixins/windowSize';
    import {fb} from '../../mixins/fb';

    export default {
        name: 'Social',
        data() {
            return {
                userEmail: '',
                showLike:false,
                loader: false,
                showEmailMethod: false,
                showEmailButtonText: 'Connect using email',
                showFBButtonText: 'Connect using Facebook',
                facebookURL:document.head.querySelector('meta[name="fb-url"]').content,
                userName:'',
                userLastName:'',
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
                    return 'Good morning!';
                } else if (curHr < 18) {
                    return 'Good afternoon!';
                } else {
                    return 'Good evening!'
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
                'requireEmail',
                'requireName',


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

            showLikeButton(){
                return this.showLike;
            }
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
                this.$store.dispatch('updateActiveComponent', 'policy');
            },

            changeLoaderStatus() {

                this.loader = !this.loader;
            },

            changeLikeButtonState(){
                return this.showLike=true;
            },

            sendToServer(method) {

                let config = {
                    onUploadProgress: progressEvent => {
                        this.changeLoaderStatus();
                    }
                };

                let hotelID = document.head.querySelector('meta[name="hotel"]');
                let hotelURL = document.head.querySelector('meta[name="hotel-url"]');
                let clientMac = document.head.querySelector('meta[name="mac-address"]');
                let loginMethod = document.head.querySelector('meta[name="login-method"]');
                axios.post('/auth/'+method,
                    {
                        email: this.userEmail,
                        name: this.userName,
                        surname: this.userLastName,
                        hotel_url: hotelURL.content,
                        hotel_id: hotelID.content,
                        mac_address: clientMac.content,
                        login_type: loginMethod.content
                    },
                    config)
                    .then(response => {

                        console.log(response)
                        document.location.href = response.data;
                        this.changeLoaderStatus()
                    })
                    .catch(e => {
                        console.log(e)
                        this.changeLoaderStatus()
                    })
            },

            showEmail() {

                this.showEmailMethod = true;
            },

            FBlogin() {
                this.showEmailMethod=false;
                window.FB.login((response)=> {
                        if (response.authResponse) {
                            window.FB.api('/me', {fields: ['email', 'name']}, (response) =>{
                                console.log(response);
                                if (typeof response.email!=='undefined'){
                                    this.showLike= true;
                                    this.userEmail = response.email;
                                    window.FB.Event.subscribe('edge.create', (response) => {
                                        console.log(response);
                                        //this.sendToServer('facebook');
                                    })
                                }
                            });
                        }
                    },
                    {
                        scope: 'email',
                        return_scopes: true
                    });
            },
        },

        mixins: [
            windowSize,
            languageDetection,
            fb
        ],
    }

</script>

<style scoped>

    .middle {
        margin-top: 15%;
    }

    .greetings {
        margin-top: 16%;
        margin-bottom: 25px;

    }

    .large-button {
        width: 70%;
        height: 50px;
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

    .soc-buttons {
        margin-bottom: 5%;
        margin-top: 5%;
        width: 60%;
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
            margin-top: 13%;
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


    /*Facebook button*/


    .loginBtn {
        box-sizing: border-box;
        position: relative;
        width: 16rem;
        margin: 0.2em;
        padding: 0 15px 0 46px;
        border: none;
        text-align: left;
        line-height: 34px;
        white-space: nowrap;
        border-radius: 0.2em;
        font-size: 16px;
        color: #FFF;
    }
    .loginBtn:before {
        content: "";
        box-sizing: border-box;
        position: absolute;
        top: 0;
        left: 0;
        width: 34px;
        height: 100%;
    }
    .loginBtn:focus {
        outline: none;
    }
    .loginBtn:active {
        box-shadow: inset 0 0 0 32px rgba(0,0,0,0.1);
    }


    /* Facebook */
    .loginBtn--facebook {
        background-color: #4C69BA;
        background-image: linear-gradient(#4C69BA, #3B55A0);
        /*font-family: "Helvetica neue", Helvetica Neue, Helvetica, Arial, sans-serif;*/
        text-shadow: 0 -1px 0 #354C8C;
        margin: 5%;
    }
    .loginBtn--facebook:before {
        border-right: #364e92 1px solid;
        background: url('/storage/images/icon_facebook.png') 6px 6px no-repeat;
    }
    .loginBtn--facebook:hover,
    .loginBtn--facebook:focus {
        background-color: #5B7BD5;
        background-image: linear-gradient(#5B7BD5, #4864B1);
    }


    /* Google */
    .loginBtn--google {
        /*font-family: "Roboto", Roboto, arial, sans-serif;*/
        background: #DD4B39;
    }
    .loginBtn--google:before {
        border-right: #BB3F30 1px solid;
        background: url('/storage/images/icon-email.png') 6px 6px no-repeat;
    }
    .loginBtn--google:hover,
    .loginBtn--google:focus {
        background: #E74B37;
    }

    .little-down{
        margin-top: 3rem;
    }
    .logo-image{
        margin-bottom: 3%;
        margin-top: 3%;
    }
    .full-name {
        margin-top: -10%;
        margin-bottom: 5%;
    }
</style>
