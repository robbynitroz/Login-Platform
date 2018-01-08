<template>
    <b-container fluid id="main-block">
        <b-row>
            <!--Main editor-->
            <b-col sm="12">
                <h3>Edit group</h3>
            </b-col>
            <b-col v-if="fetchComplete" md="12">

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



                <b-card header="Hotel Tags">
                    <br/>
                    <b-row>
                        <b-col lg="12" class="mb-3">
                            <p>Input hotel names, push enter to divide</p>
                            <input-tag placeholder="hotel names" :tags="hotelNames"></input-tag>
                        </b-col>
                        <div class="clearfix"></div>
                        <br/>
                    </b-row>

                </b-card>
                    <b-button  type="submit" size="lg" variant="primary"> Edit </b-button>
                    <b-button @click = "confirmDelete()"  type="button" size="lg" variant="danger"> Delete </b-button>
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

            <b-modal centered title="Warning" class="modal-danger" v-model="confirmDeleteAction" @ok="deleteGroup(lastID)">
                You are going to delete current group.  Press OK if you are sure!
            </b-modal>

        </b-row>
    </b-container>
</template>

<script>
    import InputTag from 'vue-input-tag';

    export default {
        name: "AddNewsFeed",
        data() {
            return {
                name:'',
                hotelNames:[],
                errors:false,
                success:false,
                ID:null,
                confirmDeleteAction:false,
                fetchComplete:false,
            }
        },
        components: {
            InputTag
        },

        computed:{

        },

        mounted() {
            axios.get('/newsfeeds/group/' + this.$route.params.id)
                .then(response => {
                    //this.loading = '';
                    this.fetchComplete = true;
                    this.groups= response.data;
                })
                .catch(e => {

                });


        },

        methods:{
            save(){

                if(this.lastID !==null){
                    return this.edit()
                }
                let data = {
                    name:this.name,
                    hotels:this.hotelNames
                }
                axios.post('/newsfeeds/group/add', data)
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
                    id:this.lastID,
                    name:this.name,
                    hotels:this.hotelNames
                }
                axios.post('/newsfeeds/group/edit', data)
                    .then(response => {
                        this.success = true
                    })
                    .catch(e => {
                        this.errors = true;
                    });
            },

            confirmDelete() {
                this.confirmDeleteAction = true
            },

            deleteGroup(id){
                axios.delete('/newsfeeds/group/delete/' + id)
                    .then(response => {
                        return this.$router.push({name: 'Groups'})
                    })
                    .catch(e => {
                        this.critError = true;
                    });
            },

        }
    }
</script>

<style>

</style>


