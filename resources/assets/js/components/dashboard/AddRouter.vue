<template>
    <div class="wrapper">

        <div v-if="allRight" class="animated fadeIn">

            <div v-if="!isEmpty" class="row">

                <div class="col-md-12">
                    <form enctype="multipart/form-data" @submit.prevent="save()">
                        <b-card>
                            <div slot="header">
                                <strong>Add router</strong>
                            </div>


                            <!--hotel-->
                            <p>Select hotel</p>
                            <model-select :options="hotels"
                                          v-model="router.hotel_id"
                                          placeholder="select Hotel">
                            </model-select>
                            <br>

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




                            <!--MAC-->
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
                                        <b-form-input type="text" v-model="router.mikrotik_username"
                                                      required
                                                      placeholder="Login..."></b-form-input>
                                    </b-input-group>
                                </b-form-fieldset>
                            </b-form-fieldset>


                            <b-form-fieldset label="Mikrotik password"
                                             description="required">
                                <b-form-fieldset>
                                    <b-input-group left="<i class='fa fa-key'></i>">
                                        <b-form-input type="password" v-model="router.mikrotik_password"
                                                      required
                                                      placeholder="Password..."></b-form-input>
                                    </b-input-group>
                                </b-form-fieldset>
                            </b-form-fieldset>



                            <div slot="footer">
                                <b-button
                                        type="submit"
                                        variant="primary"><i
                                        class="fa fa-floppy-o"></i>
                                   Save
                                </b-button>
                                <b-button :to="{name:'Routers'}" variant="secondary"><i class="fa fa-times"></i>
                                    Cancel
                                </b-button>

                            </div>
                        </b-card>
                    </form>


                </div>


            </div><!--/.col-->


            <!--Ends here-->


            <b-alert v-model="isEmpty" variant="danger">
                Wrong way or hotel doesn't exist!
                <router-link :to="{name:'Routers'}">Go back </router-link>
            </b-alert>

            <b-alert v-model="requiredID" variant="danger">
                Please select hotel
            </b-alert>
        </div><!--/.col-->
        <b-modal centered title="Warning" class="modal-danger" v-model="dangerModal" @ok="deleteRouter(delRouter.id)">
            You are going to delete {{ delRouter.ip }}.  Press OK if you are sure
        </b-modal>

        <b-modal centered title="Critical error" class="modal-danger" v-model="critError" hide-footer>
            Please contact your webmaster or support
        </b-modal>

        <b-modal centered title="Special error" class="modal-danger" v-model="specialError" hide-footer>
            IP range exceeded !!! PLEASE CONTACT SYS ADMIN AND DEVELOPER!!!
        </b-modal>

        <b-modal centered ref="myModalRef" size="sm" hide-footer title="Information">
            <div class="d-block text-center">
                <h3>{{ delRouter.ip }}  successfully deleted </h3>
            </div>
            <b-btn class="mt-3" variant="success" block @click="hideModal">OK</b-btn>
        </b-modal>

        <b-modal centered v-model="success" class="modal-success" size="sm" hide-footer title="Success">
            <div class="d-block text-center">
                <h3>Router successfully created </h3>
            </div>
        </b-modal>

    </div>


</template>

<script>

    import { ModelSelect } from 'vue-search-select'

    export default {
        name: 'EditRouter',
        components: {
            ModelSelect,
        },
        data() {
            return {

                fetchComplite: false,
                router:{
                    shortname:'',
                    description:'',
                    wanmac:'',
                    hotel_id:'',
                    mikrotik_username:'',
                    mikrotik_password:''
                },
                hotels:[],
                critError: false,
                isEmpty: true,
                dangerModal: false,
                successDel: true,
                success:false,
                uploadButton: false,
                requiredID:false,
                delRouter: {
                    id: '',
                    ip: '',
                    action: ''
                },
                specialError:false,

            }
        },

        mounted() {
            axios.get('/template/methods')
                .then(response => {
                    response.data.hotels.forEach(element =>{
                        this.hotels.push( { value:element.id, text:element.name })
                    });
                    this.fetchComplite = true;
                    this.isEmpty = false
                })
                .catch(e => {
                    this.critError = true;
                });

        },

        computed: {

            allRight(){
                if(this.fetchComplite == true){
                    return true;
                }else {
                    return false
                }
            },


        },

        methods: {

            save() {

                if(this.router.hotel_id == null || this.router.hotel_id == ''){
                    this.requiredID= true;
                    return;
                }
                axios.post('/router/add', {
                    data:this.router
                })
                    .then(response => {
                        console.log(response)
                        /*if(response.data == 'Special error'){
                            this.specialError = true;
                            return;
                        }
                        this.success = true;
                        setTimeout(() => {
                            return this.$router.push({name: 'Routers'})
                        }, 1000);*/
                    })
                    .catch(e => {
                        this.critError = true;
                    });
            },


            hideModal() {
                this.$refs.myModalRef.hide()
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