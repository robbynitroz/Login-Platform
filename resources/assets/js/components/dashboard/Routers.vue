<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <b-card header="Routers">
                        <br/>
                        <b-row>
                            <b-col lg="6" class="mb-3">
                                <h5>Please select hotel</h5>
                                <!--hotel-->
                                <model-select :options="hotels"
                                              v-model="filter"
                                              placeholder="select Hotel">
                                </model-select>
                            </b-col>
                            <b-col lg="6">
                                <h5>Refresh user list</h5>
                                <b-button @click="refreshUsers()" type="edit" variant="primary">
                                    <span v-if="spinner" class="spinner-refresh"><clip-loader :loading="loading"
                                                                                              size="16px"
                                                                                              color="#fff"></clip-loader></span>
                                    <i v-else class="fa fa-repeat"></i> Refresh
                                </b-button>
                            </b-col>
                            <div class="clearfix"></div>
                            <br/>
                            <b-col v-if="fetchComplete" lg="12">
                                <b-col lg="4" class="hotels"
                                       v-for="router in filteredList"
                                       :key="router.id"
                                >
                                    <!--Hotel blocks-->
                                    <b-card class="hotels" bg-variant="dark" text-variant="white"
                                            :title="router.nasname">
                                        <p class="card-text">
                                            Shortname: {{ router.shortname }}
                                            <br>
                                            Description: {{ router.description }}
                                        </p>
                                        <b-button @click="editRouter(router.id)" type="edit" variant="primary"><i
                                                class="fa fa-pencil-square-o"></i> Edit
                                        </b-button>
                                        <b-button @click="confirmDelete(router.id, router.nasname)" type="delete"
                                                  variant="danger"><i class="fa fa-ban"></i> Delete
                                        </b-button>
                                        <b-col v-if="statusChanged" class="hotel-logo" cols="3">
                                            <template v-if="status[router.nasname].online =='yes'">
                                                <b-badge pill variant="success">Online</b-badge>
                                                <b-badge pill variant="success">{{ status[router.nasname].users }}
                                                </b-badge>
                                            </template>
                                            <b-badge v-else pill variant="danger"> Offline</b-badge>
                                        </b-col>
                                        <b-col v-else class="hotel-logo" cols="3">
                                            <b-badge pill variant="warning"> NA</b-badge>
                                        </b-col>
                                    </b-card>
                                </b-col>
                            </b-col>
                        </b-row>
                    </b-card>
                </div><!--/.col-->
                <b-modal centered title="Warning" class="modal-danger" v-model="dangerModal"
                         @ok="deleteRouter(delRouter.id)">
                    You are going to delete {{ delRouter.ip }}. Press OK if you are sure
                </b-modal>
                <b-modal centered ref="myModalRef" size="sm" hide-footer title="Information">
                    <div class="d-block text-center">
                        <h3>{{ delRouter.ip }} successfully deleted </h3>
                    </div>
                    <b-btn class="mt-3" variant="success" block @click="actModal('hide')">OK</b-btn>
                </b-modal>
                <b-modal centered title="Critical error" class="modal-danger" v-model="critError" hide-footer>
                    Please contact your webmaster or support
                </b-modal>
            </div><!--/.row-->
        </div>
    </div>
</template>

<script>
    import {ModelSelect} from 'vue-search-select'
    import ClipLoader from 'vue-spinner/src/ClipLoader.vue'

    export default {
        name: 'Hotels',
        components: {
            ModelSelect,
            ClipLoader
        },
        data: function () {
            return {
                hotels: [],
                routers: '',
                fetchComplete: false,
                filter: '',
                filtered: [],
                dangerModal: false,
                successDel: true,
                delRouter: {
                    id: '',
                    ip: '',
                },
                critError: false,
                status: '',
                statusChanged: false,
                spinner: false
            }
        },

        mounted() {
            axios.get('/template/methods')
                .then(response => {
                    response.data.hotels.forEach(element => {
                        this.hotels.push({value: element.id, text: element.name})
                    });
                })
                .catch(e => {
                    this.critError = true;
                });
            axios.get('/routers')
                .then(response => {
                    this.routers = response.data
                    this.fetchComplete = true
                })
                .catch(e => {
                    this.critError = true;
                });
        },
        computed: {
            filteredList() {
                if (typeof this.filter == 'number') {
                    return this.routers.filter(routers => {
                        return routers.hotel_id == this.filter
                    })
                }
                return this.routers
            }
        },

        methods: {

            editRouter(id) {
                this.$router.push({name: 'Edit router', params: {routerID: id}})
            },

            actModal(action) {
                if (action == 'hide') {
                    this.$refs.myModalRef.hide()
                }
                if (action == 'show') {
                    this.$refs.myModalRef.show()
                }
            },

            confirmDelete(id, ip) {
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
                        this.afterDelete()
                        this.actModal('show')
                    })
                    .catch(e => {
                        this.critError = true;
                    });
            },
            afterDelete() {
                axios.get('/routers')
                    .then(response => {
                        this.routers = response.data
                        this.fetchComplete = true
                    })
                    .catch(e => {
                        this.critError = true;
                    });
            },

            refreshUsers() {

                this.spinner = true;
                axios.get('/mikrotik/status/' + this.filter)
                    .then(response => {
                        this.status = response.data
                        this.statusChanged = true;
                        this.spinner = false
                    })
                    .catch(e => {
                        this.critError = true;
                    });
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

    .hotel-logo {
        position: absolute;
        top: 5px;
        right: 10px;
    }

    .form-control {
        margin-left: -1px;
    }

    .spinner-refresh {
        float: left;
        margin-top: 2px;
    }

</style>