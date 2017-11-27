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
                                <b-form-input type="text" placeholder="Search for..." />
                                <b-input-group-button>
                                    <b-button variant="success">Search</b-button>
                                </b-input-group-button>
                            </b-input-group>
                        </b-col>

                        <div class="clearfix"></div>
                        <br/>

                        <b-col lg="12">

                            <b-col lg="4" class="hotels">
                            <!--Hotel blocks-->
                            <b-card class="hotels" bg-variant="dark" text-variant="white" title="Hotel CC">
                                <p class="card-text">
                                    Hotel description
                                </p>
                                <b-button type="edit" size="sm" variant="primary"><i class="fa fa-pencil-square-o"></i> Edit</b-button>
                                <b-button type="delete" size="sm" variant="danger"><i class="fa fa-ban"></i> Delete</b-button>
                            </b-card>
                            </b-col>

                            <b-col lg="4" class="hotels">
                                <!--Hotel blocks-->
                                <b-card class="hotels" bg-variant="dark" text-variant="white" title="Hotel CC">
                                    <p class="card-text">
                                        Hotel description
                                    </p>
                                    <b-button type="edit" size="sm" variant="primary"><i class="fa fa-pencil-square-o"></i> Edit</b-button>
                                    <b-button type="delete" size="sm" variant="danger"><i class="fa fa-ban"></i> Delete</b-button>
                                </b-card>
                            </b-col>

                            <b-col lg="4" class="hotels">
                                <!--Hotel blocks-->
                                <b-card class="hotels" bg-variant="dark" text-variant="white" title="Hotel CC">
                                    <p class="card-text">
                                        Hotel description
                                    </p>
                                    <b-button type="edit" size="sm" variant="primary"><i class="fa fa-pencil-square-o"></i> Edit</b-button>
                                    <b-button type="delete" size="sm" variant="danger"><i class="fa fa-ban"></i> Delete</b-button>
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

                items: [
                    {  hotel_name: "Hotel CC", web_page: 'google.com', login_method: 'email' },

                ]


            }
        },
        methods: {

        }
    }
</script>

<style>
.hotels{
    border-radius: 10px;
    float: left;
    width: 100%;
}
</style>