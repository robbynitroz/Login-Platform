<template>
    <div class="wrapper">

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <b-card header="Templates">
                                    <br/>
                    <b-row>
                        <b-col lg="6" class="mb-3">
                            <h5>Please select hotel</h5>
                            <!--hotel-->

                            <model-select :options="hotels"
                                          v-model="hotelID"

                                          placeholder="select Hotel">
                            </model-select>
                        </b-col>

                        <div class="clearfix"></div>
                        <br/>

                        <b-col v-if="selected" lg="12">

                            <b-col lg="4" class="hotels"
                            v-for="template in templates"
                                   :key="template.id"
                            >
                            <!--Hotel blocks-->
                            <b-card class="hotels" bg-variant="dark" text-variant="white" :title="template.type">
                                <p class="card-text">
                                    Created: {{ template.created_at }}
                                </p>
                                <p class="card-text">
                                    Updated: {{ template.updated_at }}
                                </p>
                                <b-button   type="edit" variant="primary"><i class="fa fa-pencil-square-o"></i> Edit</b-button>
                                <b-button  type="delete" variant="danger"><i class="fa fa-ban"></i> Delete</b-button>


                                <b-col v-if="template.activated =='yes'" class="hotel-logo" cols="3">
                                    <b-badge pill variant="success">Activated</b-badge>
                                </b-col>
                                <b-col v-if="template.schedule_start_time != null" class="hotel-logo" cols="3">
                                    <b-badge pill variant="warning">Scheduled</b-badge>
                                </b-col>
                            </b-card>
                            </b-col>
                        </b-col>

                    </b-row>
                </b-card>
            </div><!--/.col-->
            <b-modal centered title="Warning" class="modal-danger" v-model="dangerModal" @ok="">
                You are going to delete {{  }}.  Press OK if you are sure
            </b-modal>
            <b-modal centered ref="myModalRef" size="sm" hide-footer title="Information">
                <div class="d-block text-center">
                    <h3>{{  }}  successfully deleted </h3>
                </div>
                <b-btn class="mt-3" variant="success" block @click="hideModal">OK</b-btn>
            </b-modal>
        </div><!--/.row-->

    </div>

    </div>



</template>

<script>

    import { ModelSelect } from 'vue-search-select'


    export default {
        name: 'Hotels',
        components: {
            ModelSelect
        },
        data: function () {
            return {

                hotels:[],
                templates:'',
                hotelID:'',
                selected:false,
                fetchComplete:false,
                dangerModal:false,
                successDel:true,
                delHotel:{
                    id:'',
                    name:'',
                }

            }
        },

        mounted(){
            axios.get('/template/methods')
                .then(response => {
                    response.data.hotels.forEach(element =>{
                        this.hotels.push( { value:element.id, text:element.name })
                    });

                })
                .catch(e => {
                    this.critError = true;
                });
        },

        computed: {

        },
        watch: {
            // whenever question changes, this function will run
            hotelID: function (event) {
               this.downloadTemplates(event);
            }
        },

        methods: {


            downloadTemplates(id){

                axios.get('/hotel/templates/'+id)
                    .then(response => {
                        this.selected = true;
                        this.templates = response.data
                        console.log(this.templates)

                    })
                    .catch(e => {
                        this.critError = true;
                    });
            },

            editHotel (id) {

                //otelIDthis.$router.push({ name: 'Edit Hotel', params: { hotelID: id }})
            },

            hideModal () {
                this.$refs.myModalRef.hide()
            },

            confirmDelete(id, name){
                this.delHotel.id=id;
                this.delHotel.name=name;
                this.dangerModal=true
            },

            deleteHotel(id){

                let config = {
                    onUploadProgress: progressEvent => {

                    }
                };
                axios.delete('/hotel/'+id,
                    config)
                    .then(response => {

                        this.afterDelete()


                    })
                    .catch(e => {
                        //this.loading = '';

                    });
            },

            afterDelete(){

                axios.get('/hotels')
                    .then(response => {

                        this.$refs.myModalRef.show();
                        this.hotels= response.data;

                    })
                    .catch(e => {
                        //this.loading = '';

                    });
            },

        }
    }

</script>
<style scoped>
.hotels{
    border-radius: 10px;
    float: left;
    width: 100%;
}
.hotel-logo {
    position: absolute;
    top: 5px;
    right: 10px;
}
    .form-control{
        margin-left: -1px;
    }
</style>