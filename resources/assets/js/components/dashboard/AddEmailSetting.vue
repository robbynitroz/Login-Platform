<template>
    <b-container fluid id="main-block">
        <b-row>
            <!--Main editor-->
            <b-col sm="12">
            </b-col>
            <b-col md="12">
                <form class="form loginForm" @submit.prevent="save()">
                <b-form-group id="group-name"
                              label-for="type name here"
                              description="for identification purposes">
                    <b-form-input type="text"
                                  v-model="name"
                                  required
                                  placeholder="Name...">
                    </b-form-input>
                </b-form-group>
                    <b-form-group id="group-name"
                                  label-for="Push the button to generate new token">
                        <b-form-input type="text"
                                      v-model="token"
                                      required
                                      readonly
                                      placeholder="TOKEN">
                        </b-form-input>
                        <b-button @click="tokenGen()" type="button" variant="primary"> Generate </b-button>
                    </b-form-group>
                <b-card header="Select Hotels">
                    <br/>
                    <b-row>
                        <b-col lg="12" class="mb-3">
                            <v-select :value.sync="selected" multiple :options="options"></v-select>
                        </b-col>
                        <div class="clearfix"></div>
                        <br/>
                    </b-row>
                </b-card>
                    <b-card no-body>
                        <div class="card-header">
                            <div> API&nbsp;&nbsp;
                                <c-switch type="text" variant="success" on="On" off="Off"
                                          @change="swither()" :checked="apiOn"/>
                            </div>
                        </div>
                        <template v-if="apiOn">
                            <br>
                            <div class="col-md-6">
                                <b-form-group id="group-name"
                                              label-for="Push the button to generate new token">
                                    <b-form-input type="text"
                                                  v-model="apiToken"
                                                  required
                                                  readonly
                                                  placeholder="TOKEN">
                                    </b-form-input>
                                    <br>
                                    <b-button @click="tokenGen(true)" type="button" variant="primary"> Generate API token</b-button>
                                </b-form-group>
                            </div>
                        </template>
                    </b-card>
                    <b-button v-if="lastID === null" type="submit" size="lg" variant="success"> Save </b-button>
                    <template v-else>
                    <b-button  type="submit" size="lg" variant="primary"> Edit </b-button>
                    <b-button @click = "confirmDelete()"   type="button" size="lg" variant="danger"> Delete </b-button>
                    </template>
                    <b-button @click="back()"  type="button" size="lg" variant="secondary">
                        <span v-if="lastID===null">Discard</span>
                        <span v-else>Back</span>
                    </b-button>
                </form>
            </b-col>
            <!--Main editor end-->
            <b-modal centered title="Error" class="modal-danger" v-model="errors" hide-footer>
                Oops~ something went terribly wrong!
            </b-modal>
            <b-modal size="sm" centered title="Success" class="modal-success" v-model="success" hide-footer>
                <div class="d-block text-center">
                    <h3>SAVED!</h3>
                </div>
            </b-modal>
            <b-modal centered title="Warning" class="modal-danger" v-model="confirmDeleteAction" @ok="deleteSetting()">
                You are going to delete current setting.  Press OK if you are sure!
            </b-modal>
        </b-row>
    </b-container>
</template>
<script>
    import vSelect from 'vue-select';
    import cSwitch from './additional-components/Switch.vue';
    import {email} from '../../mixins/email';

    export default {
        name: "AddNewsFeed",
        data() {
            return {
                name:'',
                token:'',
                selected:[],
                preHotels:[],
                options:[],
                errors:false,
                success:false,
                lastID:null,
                confirmDeleteAction:false,
                apiOn: false,
                apiToken: '',
            }
        },

        components: {
            vSelect,
            cSwitch
        },

        computed:{
        },

        mounted() {
            this.getData();
        },

        methods:{


            save(){

                if(this.lastID !==null){
                    return this.edit()
                }
                let data = {
                    name:this.name,
                    hotels:this.transformHotelIDs(),
                    token:this.token,
                    apiOn: this.apiOn,
                    apiToken: this.apiToken,
                }
                axios.post('/settings/emails/add', data)
                    .then(response => {
                        this.lastID = response.data
                        this.success = true
                    })
                    .catch(e => {
                        this.errors = true;
                    });
            },

            edit(){
                let data = {
                    name:this.name,
                    hotels:this.transformHotelIDs(),
                    token:this.token,
                    apiOn: this.apiOn,
                    apiToken: this.apiToken,
                }
                axios.post('/settings/emails/edit/'+this.lastID, data)
                    .then(response => {
                        this.success = true
                    })
                    .catch(e => {
                        this.errors = true;
                    });
            },

            transformHotelIDs(){
                var transformed = [];
                this.selected.forEach(el=>{
                    transformed.push(el.id)
                })
                return transformed;
            },

            confirmDelete() {
                this.confirmDeleteAction = true
            },

            deleteSetting(){
                axios.delete('/settings/delete/' + this.lastID)
                    .then(response => {
                        this.back()
                    })
                    .catch(e => {
                        this.errors = true
                    });
            },

            back(){
                this.$router.push({name: 'Email list settings'})
            }
        },
        mixins: [
            email
        ],
    }
</script>
<style>
</style>


