<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <b-card no-body>
                        <div class="card-header">
                            <div> {{ name }}&nbsp;</div>
                        </div>
                        <br/>
                        <div class="container">
                            <b-row>
                                <b-col md="4" offset-md="4" sm="6" offset-sm="2" offset-xs="1"
                                       class="align-center center-block align-center">
                                    <img class="user-img" :src="picture"/>
                                </b-col>

                            </b-row>
                            <b-form-fieldset
                                    label="Your picture"
                                    description="Upload your picture, or change it || optional"
                            >
                                <b-form-file
                                        id="user-avatar"
                                        label="img"
                                        @change="imageChange"
                                ></b-form-file>
                                <b-button v-if="imageLoadStatus" @click="uploadImage()" type="button"
                                          class="preview-button"
                                          variant="primary">Upload
                                </b-button>
                                <b-alert v-model="successImage" dismissible show variant="success">
                                    Avatar successfully changed !
                                </b-alert>
                                <b-alert v-model="successImage" dismissible show variant="warning">
                                    Wrong file format!
                                </b-alert>
                            </b-form-fieldset>
                            <form @submit.prevent="save()">
                                <!--Email-->
                                <b-form-fieldset
                                        label="Your email address"
                                        description="required">
                                    <b-input-group left="<i class='fa fa-envelope'></i>">
                                        <b-form-input type="email"
                                                      required
                                                      v-model="email"
                                                      placeholder="Email"></b-form-input>
                                    </b-input-group>
                                </b-form-fieldset>
                                <b-form-fieldset
                                        label="Your name"
                                        description="required">
                                    <b-input-group left="<i class='fa fa-user'></i>">
                                        <b-form-input type="text"
                                                      required
                                                      v-model="name"
                                                      placeholder="Your name"></b-form-input>
                                    </b-input-group>
                                </b-form-fieldset>

                                <b-button
                                        type="submit"
                                        variant="success"><i
                                        class="fa fa-floppy-o"></i>
                                    Save
                                </b-button>
                            </form>
                            <br>
                        </div>
                    </b-card>
                    <b-modal
                            no-close-on-backdrop
                            no-close-on-esc
                            hide-footer
                            hide-header
                            hide-header-close
                            size="sm"
                            ok-disabled
                            cancel-disabled
                            v-model="loading"
                            centered title="Loading">
                        <div class="text-center center-block loading-modal">
                            <p style="color: #00aced; font-size: 2.2rem; font-weight: 900" class="my-4">{{
                                completed }}%</p>
                        </div>
                    </b-modal>
                    <b-modal size="sm" centered title="Success" class="modal-success" v-model="success" hide-footer>
                        <div class="d-block text-center">
                            <h3>SAVED!</h3>
                        </div>
                    </b-modal>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    export default {
        name: 'MyAccount',
        components: {},
        data: function () {
            return {
                name: '',
                email: '',
                picture: '',
                success: false,
                successImage: false,
                imageUploaded: false,
                failImage:false,
                loading:false,
                completed:0,
            }
        },
        computed: {
            imageLoadStatus(){
                return this.imageUploaded;
            }
        },

        mounted() {
            this.getUserData()
        },

        methods: {
            imageChange() {
                this.imageUploaded = true
            },

            getUserData() {
                axios.get('/user').then(response => {
                        this.id = response.data.id;
                        this.name = response.data.name;
                        this.email = response.data.email;
                        this.picture = response.data.picture;
                    }
                ).catch(

                )
            },


            uploadImage(id, save = false) {

                this.loading = true;
                let config = {
                    onUploadProgress: progressEvent => {
                        this.completed = Math.floor((progressEvent.loaded * 100) / progressEvent.total);
                    }
                }
                var data = new FormData();
                data.append('avatar', document.getElementById('user-avatar').files[0]);
                axios.post('/user/avatar/', data, config
                )
                    .then(response => {
                        if(response.data === 'Wrong file format!'){
                            this.failImage = true;
                            this.loading = false;
                            return;
                        } else{
                            this.loading = false;
                            this.picture = response.data;
                            this.imageUploaded = false;
                            this.successImage= true;
                        }
                    })
                    .catch(e => {
                        this.loading = false;
                        this.errors = true;
                    });
            },

            save() {
                axios.post('/user/change-data/', {
                    name:this.name,
                    email:this.email
                }).then(response => {
                    this.success = true;
                })
                    .catch(e => {
                        this.errors = true
                    });
            },
        }
    }

</script>
<style scoped>

    .groups {
        border-radius: 10px;
        float: left;
        width: 100%;
    }

    .hotel-logo {
        position: absolute;
        top: 5px;
        right: 10px;
    }

    .form-control {
        margin-left: -1px;
    }

    .slider {
        -webkit-appearance: none;
        width: 100%;
        height: 25px;
        background: linear-gradient(to right, yellow, green, red);
        outline: none;
        opacity: 0.7;
        -webkit-transition: .2s;
        transition: opacity .2s;
    }

    .slider:hover {
        opacity: 1;
    }

    .slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 25px;
        height: 25px;
        background: #4CAF50;
        cursor: pointer;
    }

    .slider::-moz-range-thumb {
        width: 25px;
        height: 25px;
        background: #4CAF50;
        cursor: pointer;
    }

    .percent {
        margin-bottom: -1.5rem !important;
    }

    .save-button {
        float: right;
    }

    .restart-radius {
        margin: 3%;
    }

    .restart-server {
        height: 200px;
        width: 200px;
        border-radius: 50%;
        font-size: 30px;
        margin-left: 16%;
    }

    .user-img {
        border-radius: 50%;
        height: 255px;
    }
</style>