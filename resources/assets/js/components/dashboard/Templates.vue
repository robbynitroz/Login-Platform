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
                                    Created: {{ dateTransform(template.created_at) }}

                                    <br>
                                    Updated: {{ dateTransform(template.updated_at) }}
                                </p>

                                <template v-if="template.scheduled == 'no'">
                                <b-button @click="activateTemplate(template.id)" v-if="active(template.activated, template.scheduled)" type="edit" variant="success"><i class="fa fa-check-circle-o"></i> Activate</b-button>
                                </template>
                                <b-button @click="editTemplate(template.id)"  type="edit" variant="primary"><i class="fa fa-pencil-square-o"></i> Edit</b-button>
                                <b-button @click="deleteTemplate(template.id)" v-if="active(template.activated, template.scheduled)"  type="delete" variant="danger"><i class="fa fa-ban"></i> Delete</b-button>
                                <b-button @click="previewTemplate(template.id)" variant="secondary"><i class="fa fa-play-circle"></i> Preview</b-button>

                                <template v-if="template.scheduled !== 'yes'">
                                <b-col v-if="template.activated =='yes'" class="hotel-logo" cols="3">
                                    <b-badge pill variant="success">Activated</b-badge>
                                </b-col>
                                </template>

                                <template v-if="template.scheduled == 'yes'">
                                <b-col class="hotel-logo" cols="3">
                                    <b-badge pill variant="warning">Scheduled</b-badge>
                                    <p class="schedule-dates">Start Date: {{ dateTransform(template.schedule_start_time,true) }} <br>  End Date: {{ dateTransform(template.schedule_end_time,true) }}</p>
                                </b-col>

                                </template>

                            </b-card>
                            </b-col>
                        </b-col>

                    </b-row>
                </b-card>
            </div><!--/.col-->
            <b-modal centered title="Warning" class="modal-danger" v-model="dangerModal" @ok="confirmDelete()">
                You are going to delete template!  Are you sure ?
            </b-modal>
            <b-modal centered title="Please confirm" class="modal-warning" v-model="activeModal" @ok="confirmActivation()">
                You are going to activate selected template!  Are you sure ?
            </b-modal>
            <b-modal centered ref="myModalRef" size="sm" hide-footer title="Information">
                <div class="d-block text-center">
                    <h3>{{   }}  successfully deleted </h3>
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
                activeModal:false,
                goDel:'',
                goAct:''

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

            active(active, scheduled){
                if(active =='yes' && scheduled =='no'){
                    return false;
                } else if(active =='yes' && scheduled == 'yes'){
                    return true
                } else {
                    return true
                }
            },

            dateTransform(date, showTime = false){
                let d= new Date(date);
                let options = {
                     hour: "2-digit", minute: "2-digit"
                };
                if(showTime===true){
                    return d.toLocaleDateString("en-GB", options);
                }
                return d.toLocaleDateString("en-GB");
            },


            downloadTemplates(id){

                axios.get('/hotel/templates/'+id)
                    .then(response => {
                        this.selected = true;
                        this.templates = response.data

                    })
                    .catch(e => {
                        this.critError = true;
                    });
            },

            editTemplate (id) {

                this.$router.push({ name: 'Edit Template', params: { id: id }})
            },

            confirmDelete(){
                //Delete action
            },

            deleteTemplate(id){
                this.goDel=id;
                this.dangerModal=true;

            },

            confirmActivation(){

            },

            activateTemplate(id){
                this.activeModal = true
                this.goAct = id
            },

            previewTemplate(id){

                axios.post('/template/preview', {
                    id:id,
                    type:'alreadySaved'
                })
                    .then(response => {
                       console.log(response);
                         window.open('/preview/'+response.data);
                    })
                    .catch(e => {
                        this.loading = false;
                        this.critError = true;


                    });
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

.card-text{
    margin-top:25px;
}

    .schedule-dates{
        margin-left: -115px;
    }
</style>