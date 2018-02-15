<template>
    <div class="wrapper">
        <div v-if="allRight" class="animated fadeIn">
            <div v-if="!isEmpty" class="row">
                <div class="col-md-12">
                    <form enctype="multipart/form-data" @submit.prevent="edit()">
                        <b-card>
                            <div slot="header">
                                <strong>{{ router.nasname }}</strong>
                            </div>
                            <!--Router IP-->
                            <b-form-fieldset label="Router IP address"
                                             description="Router IP address assigned by system || can't be changed ">
                                <b-form-fieldset>
                                    <b-input-group left="<i class='fa fa-link'></i>">
                                        <b-form-input type="text" v-model="router.nasname"
                                                      disabled
                                                      readonly
                                        ></b-form-input>
                                    </b-input-group>
                                </b-form-fieldset>
                            </b-form-fieldset>
                            <!--Router shortname-->
                            <b-form-fieldset label="Shortname" description="Type something short">
                                <b-form-fieldset>
                                    <b-input-group left="<i class='fa fa-info'></i>">
                                        <b-form-input type="text" v-model="router.shortname"
                                                      required
                                                      placeholder="Name..."></b-form-input>
                                    </b-input-group>
                                </b-form-fieldset>
                            </b-form-fieldset>
                            <!--desc-->
                            <b-form-fieldset label="Full description"
                                             description="Enter full description">
                                <b-form-fieldset>
                                    <b-input-group left="<i class='fa fa-info-circle'></i>">
                                        <b-form-input type="text" v-model="router.description"
                                                      placeholder="Description..."></b-form-input>
                                    </b-input-group>
                                </b-form-fieldset>
                            </b-form-fieldset>
                            <!--hotel-->
                            <p>Select hotel</p>
                            <model-select :options="hotels"
                                          v-model="router.hotel_id"
                                          placeholder="select Hotel">
                            </model-select>
                            <br>
                            <!--desc-->
                            <b-form-fieldset label="WAN MAC address"
                                             description="not required">
                                <b-form-fieldset>
                                    <b-input-group left="<i class='fa fa-server'></i>">
                                        <b-form-input type="text" v-model="router.wanmac"
                                                      placeholder="WAN MAC"></b-form-input>
                                    </b-input-group>
                                </b-form-fieldset>
                            </b-form-fieldset>
                            <hr>
                            <h5>Mikrotik credentials</h5>
                            <!--desc-->
                            <b-form-fieldset label="Mikrotik login"
                                             description="required">
                                <b-form-fieldset>
                                    <b-input-group left="<i class='fa fa-sign-in'></i>">
                                        <b-form-input autocomplete="false" type="text" v-model="mikrotik_username"
                                                      placeholder="Login..."></b-form-input>
                                    </b-input-group>
                                </b-form-fieldset>
                            </b-form-fieldset>
                            <b-form-fieldset label="Mikrotik password"
                                             description="required">
                                <b-form-fieldset>
                                    <b-input-group left="<i class='fa fa-key'></i>">
                                        <b-form-input autocomplete="false" type="password" v-model="mikrotik_password"
                                                      placeholder="Password..."></b-form-input>
                                    </b-input-group>
                                </b-form-fieldset>
                            </b-form-fieldset>
                            <div slot="footer">
                                <b-button
                                        type="submit"
                                        variant="primary"><i
                                        class="fa fa-floppy-o"></i>
                                    Edit
                                </b-button>
                                <b-button :to="{name:'Routers'}" variant="secondary"><i class="fa fa-times"></i>
                                    Cancel
                                </b-button>
                                <b-button @click="confirmDelete(router.id, router.secret, 'delete')" variant="danger">
                                    <i class="fa fa-ban"></i> Delete
                                </b-button>
                            </div>
                        </b-card>
                    </form>
                </div>
            </div><!--/.col-->
            <!--Ends here-->
            <b-alert v-model="isEmpty" variant="danger">
                Wrong way or hotel doesn't exist!
                <router-link :to="{name:'Routers'}">Go back</router-link>
            </b-alert>
            <b-alert v-model="requiredID" variant="danger">
                Please select hotel
            </b-alert>
        </div><!--/.col-->
        <b-modal centered title="Warning" class="modal-danger" v-model="dangerModal" @ok="deleteRouter(delRouter.id)">
            You are going to delete {{ delRouter.ip }}. Press OK if you are sure
        </b-modal>

        <b-modal centered title="Critical error" class="modal-danger" v-model="critError" hide-footer>
            Please contact your webmaster or support
        </b-modal>
        <b-modal centered ref="myModalRef" size="sm" hide-footer title="Information">
            <div class="d-block text-center">
                <h3>{{ delRouter.ip }} successfully deleted </h3>
            </div>
            <b-btn class="mt-3" variant="success" block @click="hideModal">OK</b-btn>
        </b-modal>

        <b-modal centered v-model="success" class="modal-success" size="sm" hide-footer title="Success">
            <div class="d-block text-center">
                <h3> {{ router.secret }} successfully updated </h3>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import {ModelSelect} from 'vue-search-select'

    export default {
        name: 'EditRouter',
        components: {
            ModelSelect,
        },
        data: function () {
            return {
                fetchComplite: {
                    first: false,
                    second: false,
                },
                router: false,
                hotels: [],
                critError: false,
                isEmpty: true,
                dangerModal: false,
                successDel: true,
                success: false,
                uploadButton: false,
                requiredID: false,
                delRouter: {
                    id: '',
                    ip: '',
                    action: ''
                },
                mikrotik_password: '',
                mikrotik_username: '',

            }
        },

        mounted() {
            let config = {
                onUploadProgress: progressEvent => {

                }
            };
            axios.get('/router/' + this.$route.params.routerID,
                config)
                .then(response => {

                    if (response.data.id) {
                        this.isEmpty = false;
                        this.router = response.data;
                    } else {
                        this.isEmpty = true;
                    }
                    this.fetchComplite.first = true;
                })
                .catch(e => {
                    this.critError = true;

                });

            axios.get('/template/methods')
                .then(response => {
                    response.data.hotels.forEach(element => {
                        this.hotels.push({value: element.id, text: element.name})
                    });
                    this.fetchComplite.second = true;
                })
                .catch(e => {
                    this.critError = true;
                });

        },

        computed: {

            allRight() {
                if (this.fetchComplite.first == true && this.fetchComplite.second == true) {
                    return true;
                } else {
                    return false
                }
            },
        },

        methods: {

            edit() {

                if (this.router.hotel_id == null || this.router.hotel_id == '') {
                    this.requiredID = true;
                    return;
                }
                axios.put('/router/' + this.$route.params.routerID, {
                    data: this.router,
                    mikrotik_username: this.mikrotik_username,
                    mikrotik_password: this.mikrotik_password
                })
                    .then(response => {
                        this.success = true;
                        setTimeout(() => {
                            return this.$router.push({name: 'Routers'})
                        }, 750);
                    })
                    .catch(e => {
                        this.critError = true;
                    });
            },

            hideModal() {
                this.$refs.myModalRef.hide()
            },

            confirmDelete(id, ip, action) {
                this.delRouter.id = id;
                this.delRouter.ip = ip;
                this.dangerModal = true
            },

            deleteRouter(id) {
                let config = {
                    onUploadProgress: progressEvent => {

                    }
                };
                axios.delete('/router/' + id,
                    config)
                    .then(response => {
                        this.afterDelete();
                        setTimeout(() => {
                            return this.$router.push({name: 'Routers'})
                        }, 750);
                    })
                    .catch(e => {
                        this.critError = true;
                    });
            },

            afterDelete() {
                this.$refs.myModalRef.show();

            },
        }
    }

</script>

<style scoped>
    .hotels {
        border-radius: 10px;
        float: left;
        width: 100%;
    }

    .form-control {
        margin-left: -1px;
    }
</style>