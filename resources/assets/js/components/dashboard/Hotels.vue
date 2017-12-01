<template>
    <div class="wrapper">

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <b-card header="Hotels">
                                    <br/>
                    <b-row>
                        <b-col lg="6" class="mb-3">
                            <b-input-group>
                                <b-input-group-button>
                                    <b-button variant="success"><i class="fa fa-search"></i></b-button>
                                </b-input-group-button>
                                <b-form-input v-model="filter" type="text" placeholder="Search for..." />
                                <b-input-group-button>
                                    <b-button variant="success">Search</b-button>
                                </b-input-group-button>
                            </b-input-group>
                        </b-col>

                        <div class="clearfix"></div>
                        <br/>

                        <b-col v-if="fetchComplete" lg="12">

                            <b-col lg="4" class="hotels"
                            v-for="hotel in filteredList"
                                   :key="hotel.id"
                            >
                            <!--Hotel blocks-->
                            <b-card class="hotels" bg-variant="dark" text-variant="white" :title="hotel.name">
                                <p class="card-text">
                                    {{ hotel.main_url }}
                                </p>
                                <b-button @click="editHotel(hotel.id)"  type="edit" variant="primary"><i class="fa fa-pencil-square-o"></i> Edit</b-button>
                                <b-button @click="confirmDelete(hotel.id, hotel.name)" type="delete" variant="danger"><i class="fa fa-ban"></i> Delete</b-button>

                                <img class="hotel-logo" :src="'/storage/images/'+ hotel.logo">
                            </b-card>
                            </b-col>
                        </b-col>

                    </b-row>
                </b-card>
            </div><!--/.col-->
            <b-modal centered title="Warning" class="modal-danger" v-model="dangerModal" @ok="deleteHotel(delHotel.id)">
                You are going to delete {{ delHotel.name }}.  Press OK if you are sure
            </b-modal>
            <b-modal centered ref="myModalRef" size="sm" hide-footer title="Information">
                <div class="d-block text-center">
                    <h3>{{ delHotel.name }}  successfully deleted </h3>
                </div>
                <b-btn class="mt-3" variant="success" block @click="hideModal">OK</b-btn>
            </b-modal>
        </div><!--/.row-->

    </div>

    </div>



</template>

<script>



    export default {
        name: 'Hotels',
        components: {

        },
        data: function () {
            return {

                hotels:{},
                fetchComplete:false,
                filter:'',
                filtered:[],
                dangerModal:false,
                successDel:true,
                delHotel:{
                    id:'',
                    name:'',
                }



            }
        },

        mounted(){
            let config = {
                onUploadProgress: progressEvent => {

                }
            };
            axios.get('/hotels',
                config)
                .then(response => {
                    //this.loading = '';
                    this.fetchComplete = true;
                    this.hotels= response.data;


                })
                .catch(e => {
                    //this.loading = '';

                });
        },

        computed: {
            filteredList() {
                return this.hotels.filter(hotel => {
                    return hotel.name.toLowerCase().includes(this.filter.toLowerCase())
                })
            }
        },

        methods: {

            editHotel (id) {

                this.$router.push({ name: 'Edit Hotel', params: { hotelID: id }})
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
    .hotel-logo{
        width: 200px;
        position: absolute;
        top:30px;
        right:10px;
    }
    .form-control{
        margin-left: -1px;
    }
</style>