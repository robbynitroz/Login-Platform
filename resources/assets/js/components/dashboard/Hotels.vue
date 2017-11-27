<template>
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
                                <b-button  type="edit" size="sm" variant="primary"><i class="fa fa-pencil-square-o"></i> Edit</b-button>
                                <b-button @click="deleteHotel(hotel.id)" type="delete" size="sm" variant="danger"><i class="fa fa-ban"></i> Delete</b-button>
                                <img class="hotel-logo" :src="'/storage/images/'+ hotel.logo">
                            </b-card>
                            </b-col>






                        </b-col>

                    </b-row>



                </b-card>
            </div><!--/.col-->
        </div><!--/.row-->
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
                milter:['spray', 'limit', 'elite', 'exuberant', 'destruction', 'present']


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

            deleteHotel(id){

                let config = {
                    onUploadProgress: progressEvent => {

                    }
                };
                axios.delete('/hotels/'+id,
                    config)
                    .then(response => {

                        console.log(response);


                    })
                    .catch(e => {
                        //this.loading = '';

                    });
            }

        }
    }

</script>

<style>
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
</style>