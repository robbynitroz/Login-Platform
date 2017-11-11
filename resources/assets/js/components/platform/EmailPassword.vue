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


                    <div class="clearfix"></div>
                    <div class="offset-lg-4 col-lg-4 offset-md-3 col-md-6">
                        <!-- login form -->
                        <form class="form loginForm" @submit.prevent="checkLoginData">
                            <label hidden for="email">Email</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input @keyup="errors = false" id="email" class="form-control" name="email" placeholder="Email" required type="email"
                                       v-model="email"
                                       :disabled="success == true">
                            </div>

                            <button type="submit" :disabled="success == true" class="btn btn-lg btn-block">Submit</button>
                            <div class="clearfix back-to-login"></div>

                            <router-link class="back-to-login" to="/login"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back to Login</router-link>

                        </form>

                        <div class="clearfix"></div>
                        <!-- errors -->
                        <transition name="fade">
                            <div v-if="errors" class="alert alert-danger error-class" role="alert">
                                Email doesn't registered in system, please check your entry!
                            </div>

                            <div v-if="success" class="alert alert-success error-class" role="alert">
                                Email has been sent with password reset instructions, please check your inbox
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import {loginBackground} from '../../mixins/login-background'

    export default {
        name: 'restorePassword',
        data() {
            return {
                loading: '',
                email: '',
                response: '',
                errors:false,
                success:false



            }
        },

        computed: {},

        mounted: function () {
            // this.context=(this.$refs.canvas.getContext("2d"))
            // console.log(this.$refs.canvas)

        },

        methods: {


            changeLoaderStatus(){
              this.loading = 'compass'
            },


            checkLoginData() {
                /* Making API call to authenticate a user */

                let config = {
                    onUploadProgress: progressEvent => {
                        this.changeLoaderStatus();
                    }
                };
                axios.post('/password/email',
                    {
                        email: this.email,

                    }, config)
                    .then(response => {
                        let res = response.data;
                        this.loading='';
                        if(res=='success'){
                            this.success=true;
                        }else {
                            this.errors=true;
                        }
                        this.loading='';
                    })
                    .catch(e => {
                        this.errors=true;
                        this.loading='';
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

    .remember {
        color: white;
        /*margin: 1rem 0 0 0;*/
        float: left;

    }


    .restore {
        float: right;
        color:white;
    }

    .restore:hover {
        color: #176282e8;
    }

    .remember, .restore {
        margin-top: 1rem;
    }

    .custom-control-input:checked ~ .custom-control-indicator{
        background-color:#2087b0 !important;
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
    .fade-enter, .fade-leave-to  {
        opacity: 0
    }

    .back-to-login{
        color: white;
        margin-top: 10px;
    }
    .back-to-login i{
        color: white;
    }

    .compass {
        -webkit-animation:spin 0.8s linear infinite;
        -moz-animation:spin 0.8s linear infinite;
        animation:spin 0.8s linear infinite;
    }
    @-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } }
    @-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } }
    @keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } }

</style>