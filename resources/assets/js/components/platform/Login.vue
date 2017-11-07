<template>
    <div class="container-fluid">
        <canvas id="canvas"
                ref="canvas"></canvas>
        <div class="vertical-center">
            <div class="container justify-content-center">
                <div class="row">


                    <div class="col-md-12 text-center">
                        <img alt="guestcompass_logo" src="storage/images/logo.png">
                    </div>


                    <div class="clearfix"></div>
                    <div class="offset-lg-4 col-lg-4 offset-md-3 col-md-6">
                        <!-- login form -->
                        <form class="form loginForm" @submit.prevent="checkLoginData">
                            <label hidden for="email">Email</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input id="email" class="form-control" name="email" placeholder="Email" type="email"
                                       v-model="email">
                            </div>
                            <label hidden for="password">Password</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input id="password" class="form-control" name="password" placeholder="Password"
                                       type="password" v-model="password">
                            </div>
                            <button type="submit" class="btn btn-lg btn-block">Login</button>
                            <div class="clearfix"></div>
                            <label class="form-check-label remember">
                                <input name="remember" type="checkbox" class="form-check-input">
                                Remember me
                            </label>
                            <a class="badge badge-light restore" href="">Forgot password?</a>
                        </form>

                        <!-- errors -->
                        <div v-if=response class="text-red"><p>{{response}}</p></div>
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
        name: 'platform-login',
        data() {
            return {
                section: 'Login',
                loading: '',
                email: '',
                password: '',
                response: '',
                errorsEmail: false,
                errorsPassword: false,


            }
        },

        computed: {},

        mounted: function () {
            // this.context=(this.$refs.canvas.getContext("2d"))
            // console.log(this.$refs.canvas)

        },

        methods: {


            checkLoginData() {
                /* Making API call to authenticate a user */



                axios.post('/login',
                    {
                        email: this.email,
                        password: this.password
                    })
                    .then(response => {
                        console.log(response)

                    })
                    .catch(e => {
                        console.log(e)

                    });


            }


        },

        mixins: [
            loginBackground
        ],
    }
</script>

<style>


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
        background-color: #0d0631;
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
    }

    .remember, .restore {
        margin-top: 1rem;
    }

    .btn {
        background-color: #1762828c;
        color: white;
    }

    .btn:hover {
        background-color: #176282e8;
    }

    .fa {
        color: #14395d;
    }


</style>