<template>
    <div class="container-fluid">
        <div class="vertical-center">
            <div class="container justify-content-center">
                <div class="row">


                    <div class="col-12 text-center">
                        <img  src="storage/images/logo-gc.png">
                    </div>


                <div class="text-center col-6 offset-3">
                    <!-- login form -->
                    <form class="ui form loginForm"  @submit.prevent="checkCreds">

                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input class="form-control" name="username" placeholder="Username" type="text" v-model="username">
                        </div>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input class="form-control" name="password" placeholder="Password" type="password" v-model="password">
                        </div>
                        <button type="submit" v-bind:class="'btn btn-primary btn-lg ' + loading">Login</button>
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

    export default {
        name: 'platform-login',
        data () {
            return {
                section: 'Login',
                loading: '',
                username: '',
                password: '',
                response: ''
            }
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
        }
    }
</script>

<style>
    html,
    body {
        height: 100%
    }

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




</style>