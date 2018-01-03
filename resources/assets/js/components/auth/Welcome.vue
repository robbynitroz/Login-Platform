<template>
    <div class="container-fluid">
        <canvas id="canvas"
                ref="canvas"></canvas>
        <div class="vertical-center">
            <div class="container justify-content-center">
                <div class="row">


                    <div class="col-md-12 text-center logo">
                        <img :class="loading" class="logo-arrow" alt="guestcompass_logo-arrow" src="/storage/images/logo-layer2.png">
                        <img class="logo-back" alt="guestcompass_logo-back" src="/storage/images/logo-layer1.png">
                    </div>

                    <transition name="animated">
                    <div v-show="welcome" style="color: white"  class="col-sm-6 offset-sm-3 text-center" ><h1 class="animated" >{{ welcome }}</h1>
                        <transition name="entry" appear mode="out-in">
                            <div v-if="links" class="links">
                                <router-link class="left-fl" to="/login"> Login </router-link>
                                <a class="right-fl" href="http://guestcompass.nl/wifi-platform/" target="_blank"> About project </a>
                            </div>
                        </transition>
                    </div>
                    </transition>

                    <div class="clearfix"></div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import {loginBackground} from '../../mixins/login-background'

    export default {
        name: 'Welcome',
        data() {
            return {
                loading: 'compass',
                welcome:false,
                links:false,

            }
        },

        computed: {},

        mounted: function () {
            document.title = "GuestCompass WiFi Platform";
            setTimeout(()=>{
                this.loading=''
                this.welcome='GuestCompass'
                this.triggerSecond()

            }, 1500)


        },

        methods: {

            triggerSecond(){
                setTimeout(()=>{
                    this.links = true;
                }, 600)
            },

            changeLoaderStatus(){
                this.loading = 'compass'
            },



        },

        mixins: [
            loginBackground
        ],
    }
</script>


<style scoped>

    @import "~bootstrap/dist/css/bootstrap.css";
    @import "~font-awesome/css/font-awesome.css";



    .vertical-center {
        min-height: 100%; /* Fallback for vh unit */
        min-height: 100vh;
        /* Make it a flex container */
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;

        /* Align the bootstrap's container vertically */
        -webkit-box-align: center;
        -webkit-align-items: center;
        -moz-box-align: center;
        -ms-flex-align: center;
        align-items: center;

        /* In legacy web browsers such as Firefox 9
           we need to specify the width of the flex container */
        width: 100%;

        /* Also 'margin: 0 auto' doesn't have any effect on flex items in such web browsers
           hence the bootstrap's container won't be aligned to the center anymore.

           Therefore, we should use the following declarations to get it centered again */
        -webkit-box-pack: center;
        -moz-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
    }



    .container-fluid {
        background-color: #2087b0;
    / / #280B29 background: radial-gradient(ellipse at center, rgba(49, 16, 47, 1) 0 %, rgba(40, 11, 41, 1) 100 %);
        font-family: 'Russo One', sans-serif;
    }

    #canvas {
        top: 50%;
        left: 50%;
        min-width: 100%;
        min-height: 100%;
        width: auto;
        height: auto;
        z-index: -100;
        -webkit-transform: translateX(-50%) translateY(-50%);
        transform: translateX(-50%) translateY(-50%);
        background-size: contain;
    }

    #canvas {
        display: block;
        position: absolute;
        width: 100%;
        height: 16rem;
        height: 100vh;
        z-index: 1;
    }

    .logo img{
        width: 12.5rem;
    }

    .row {
        position: relative;
        z-index: 999;
    }

    .logo-back{
        z-index: 2;
    }
    .logo-arrow{
        position: fixed;
        z-index: 3;

    }

    .animated {
        display: inline-block;
    }

    .animated-enter-active, .animated-leave-active {
        animation: fadein .5s;
    }

    .animated-enter, .animated-leave-active {
        animation: fadeout .5s;
    }

    @keyframes fadein {
        0% {
            transform: scale(0);
        }
        50% {
            transform: scale(1.5);
        }
        100% {
            transform: scale(1);
        }
    }

    @keyframes fadeout {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.5);
        }
        100% {
            transform: scale(0);
        }
    }


    .compass {
        -webkit-animation:spin 0.8s linear infinite;
        -moz-animation:spin 0.8s linear infinite;
        animation:spin 0.8s linear infinite;
    }
    @-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } }
    @-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } }
    @keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } }


    /*Links transition*/

    .entry-enter {

        opacity: 0;
    }

    .entry-enter-active {
        transition: opacity 0.6s;

    }

    .entry-leave {
        opacity: 1;

    }

    .entry-leave-active {
        transition: opacity 0.6s;
        opacity: 0;

    }

    @media screen and (max-width: 576px) {
        .container-fluid {
            padding: 0;
        }

    }

    /*End link transition*/



    .links{
        margin-top: 10px;
    }

    .left-fl{
        float: left;
        padding: 0 0 0 22%;
    }
    .right-fl{
        float: right;
        padding: 0 22% 0 0;
    }
    .right-fl, .left-fl{
        color: #ffffff;
        font-style: italic;
    }



</style>