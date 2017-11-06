<template>
    <div class="container-fluid">
        <canvas id="canvas"
                ref="canvas"></canvas>
        <div class="vertical-center">
            <div class="container justify-content-center">
                <div class="row">


                    <div class="col-md-12 text-center">
                        <img alt="guestcompass_logo"  src="storage/images/logo.png">
                    </div>


                    <div class="clearfix"></div>
                <div class="offset-lg-4 col-lg-4 offset-md-3 col-md-6">
                    <!-- login form -->
                    <form class="form loginForm"  @submit.prevent="checkCreds">
                        <label hidden for="email">Email</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input id="email" class="form-control" name="email" placeholder="Email" type="email" v-model="email">
                        </div>
                        <label hidden for="password">Password</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input id="password" class="form-control" name="password" placeholder="Password" type="password" v-model="password">
                        </div>
                        <button type="submit"  class="btn btn-primary btn-lg btn-block">Login</button>
                        <div class="clearfix"></div>
                        <label class="form-check-label remember">
                            <input type="checkbox" class="form-check-input">
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
        data () {
            return {
                section: 'Login',
                loading: '',
                email: '',
                password: '',
                response: '',


            }
        },

        computed:{


        },

        mounted: function() {
           // this.context=(this.$refs.canvas.getContext("2d"))
          // console.log(this.$refs.canvas)

        },

        methods: {




            /*checkCreds () {



                /!* Making API call to authenticate a user *!/
                api.request('post', '/login', {username, password})
                    .then(response => {
                        this.toggleLoading()

                        var data = response.data
                        /!* Checking if error object was returned from the server *!/
                        if (data.error) {
                            var errorName = data.error.name
                            if (errorName) {
                                this.response = errorName === 'InvalidCredentialsError'
                                    ? 'Username/Password incorrect. Please try again.'
                                    : errorName
                            } else {
                                this.response = data.error
                            }

                            return
                        }

                        /!* Setting user in the state and caching record to the localStorage *!/
                        if (data.user) {
                            var token = 'Bearer ' + data.token

                            this.$store.commit('SET_USER', data.user)
                            this.$store.commit('SET_TOKEN', token)

                            if (window.localStorage) {
                                window.localStorage.setItem('user', JSON.stringify(data.user))
                                window.localStorage.setItem('token', token)
                            }

                            this.$router.push(data.redirect ? data.redirect : '/')
                        }
                    })
                    .catch(error => {
                        this.$store.commit('TOGGLE_LOADING')
                        console.log(error)

                        this.response = 'Server appears to be offline'
                        this.toggleLoading()
                    })
            },
            toggleLoading () {
                this.loading = (this.loading === '') ? 'loading' : ''
            },
            resetResponse () {
                this.response = ''
            }*/



        },

        mixins:[
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


    .input-group{
        margin: 1rem 0 1rem 0;
    }


    .container-fluid {
        background-color: #31102F; //#280B29
    background: radial-gradient(ellipse at center, rgba(49,16,47,1) 0%, rgba(40,11,41,1) 100%);
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
    .row{
        position: relative;
        z-index: 999;
    }


    .remember{
        color: white;
       /*margin: 1rem 0 0 0;*/
        float: left;

    }
    .restore{
        float: right;
    }


    .remember, .restore{
        margin-top: 1rem;
    }


</style>