<template>
    <div class="container-fluid">
        <canvas id="canvas"
                ref="canvas"></canvas>
        <div class="vertical-center">
            <div class="container justify-content-center">
                <div class="row">


                    <div class="col-md-12 text-center logo">
                        <img :class="loading" class="logo-arrow" alt="guestcompass_logo-arrow"
                             src="/storage/images/logo-layer2.png">
                        <img class="logo-back" alt="guestcompass_logo-back" src="/storage/images/logo-layer1.png">
                    </div>
                    <div class="clearfix"></div>
                    <div class="offset-lg-4 col-lg-4 offset-md-3 col-md-6">
                        <!-- login form -->
                        <form class="form loginForm" @submit.prevent="checkLoginData">
                            <label hidden for="email">Email</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input @keyup="errors = false" id="email" class="form-control" name="email"
                                       placeholder="Email" required type="email"
                                       v-model="email">
                            </div>

                            <label hidden for="password">Password</label>
                            <div :class="['input-group', counter('main')]">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input @keyup="counter('main')" id="password" class="form-control" name="password"
                                       placeholder="Password" min="6" required
                                       type="password" v-model="password">
                            </div>

                            <label hidden for="password">Password confirm</label>
                            <transition name="flip" mode="out-in">
                            <div v-if="activeConfirm" :class="['input-group', counter('secondary')]">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input @keyup="counter('secondary')" id="password-confirm" class="form-control" name="password-confirm"
                                       placeholder="Password confirmation" required
                                       type="password" v-model="passwordConfirm">
                            </div>
                            </transition>
                            <transition name="flip" mode="out-in">
                            <button type="submit" class="btn btn-lg btn-block"
                                   v-if="equal"
                                   >
                                Submit</button>
                            </transition>
                            <div class="clearfix"></div>

                        </form>

                        <div class="clearfix"></div>
                        <!-- errors -->
                        <transition name="fade">
                            <div v-if="errors" class="alert alert-danger error-class" role="alert">
                                Email or password are wrong check out your entry please!
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //import api from '../api'

    import {loginBackground} from '../../mixins/login-background'

    export default {
        name: 'ResetPassword',
        data() {
            return {
                section: 'ResetPassword',
                loading: '',
                email: '',
                password: '',
                passwordConfirm:'',
                activeConfirm:false,
                equal:false,
                errors: false,
            }
        },

        computed: {},



        mounted: function () {
            document.title = "Login";

        },



        methods: {

            changeLoaderStatus() {
                this.loading = 'compass'
            },


            counter(param){

                if(param =='main') {
                    if (this.password.length < 6 && this.password.length > 0) {
                        this.activeConfirm=false;
                        return 'red-border'
                    } else if (this.password.length >= 6) {
                        this.activeConfirm=true;
                        return 'green-border';
                    }
                    return '';
                }

                if(param =='secondary') {
                    if (this.password !==this.passwordConfirm && this.passwordConfirm.length > 0) {
                        this.equal=false;
                        return 'red-border'
                    } else if (this.password ===this.passwordConfirm && this.passwordConfirm.length > 0) {
                        this.equal=true;
                        return 'green-border';
                    }
                    return '';
                }

            },



            checkLoginData() {


                let config = {
                    onUploadProgress: progressEvent => {
                        this.changeLoaderStatus();
                    }
                };

                axios.post('/password/reset',
                    {
                        email: this.email,
                        password: this.password,
                        password_confirmation:this.passwordConfirm,
                        token: document.head.querySelector('meta[name="token"]').content
                    }, config)
                    .then(response => {
                        console.log(response)
                    })
                    .catch(e => {
                        this.loading = '';
                        this.errors = true;
                    });
            }
        },

        mixins: [
            loginBackground
        ],
    }
</script>

<style scoped>


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

    .input-group {
        margin: 1rem 0 1rem 0;
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

    .logo img {
        width: 12.5rem;
    }

    .row {
        position: relative;
        z-index: 999;
    }

    .remember {
        color: white;
        /*margin: 1rem 0 0 0;*/
        float: left;

    }

    .restore {
        float: right;
        color: white;
    }

    .restore:hover {
        color: #176282e8;
    }

    .remember, .restore {
        margin-top: 1rem;
    }

    .custom-control-input:checked ~ .custom-control-indicator {
        background-color: #2087b0 !important;
    }

    .btn {
        background-color: #1762828c;
        color: white;
    }

    .btn:hover {
        background-color: #176282e8;
    }

    .fa {
        color: #2087b0;
    }

    .logo-back {
        z-index: 2;
    }

    .logo-arrow {
        position: fixed;
        z-index: 3;

    }

    .error-class{
        position: absolute;
    }

    @media screen and (max-width: 365px) {
        .remember, .restore {
            font-size: 0.95rem;
        }
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }

    .fade-enter, .fade-leave-to {
        opacity: 0
    }

    .red-border input{
        border-top: 1px solid #ff5856 !important;
        border-bottom: 1px solid #ff5856 !important;
        border-right: 1px solid #ff5856 !important;
    }
    .green-border input{
        border-top: 1px solid #0bfc00 !important;
        border-bottom: 1px solid #0bfc00 !important;
        border-right: 1px solid #0bfc00 !important;

    }

    .red-border span{
        border-top: 1px solid #ff5856 !important;
        border-bottom: 1px solid #ff5856 !important;
        border-left: 1px solid #ff5856 !important;
    }
    .green-border span{
        border-top: 1px solid #0bfc00 !important;
        border-bottom: 1px solid #0bfc00 !important;
        border-left: 1px solid #0bfc00 !important;

    }



    .compass {
        -webkit-animation: spin 0.8s linear infinite;
        -moz-animation: spin 0.8s linear infinite;
        animation: spin 0.8s linear infinite;
    }



    /*Flip transition start*/

    .flip-enter{

    }
    .flip-enter-active{
        animation: flip-in 0.5s ease-out forwards;
    }
    .flip-leave{


    }
    .flip-leave-active{
        animation: flip-out 0.5s ease-out forwards;
    }
    @keyframes flip-out {

        from {
            transform: rotateY(0deg)
        }
        to{

            transform: rotateY(90deg)

        }
    }

    @keyframes flip-in {

        from {
            transform: rotateY(90deg)
        }
        to{

            transform: rotateY(0deg)

        }
    }
    /*flip transition end*/

    @-moz-keyframes spin {
        100% {
            -moz-transform: rotate(360deg);
        }
    }

    @-webkit-keyframes spin {
        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

</style>