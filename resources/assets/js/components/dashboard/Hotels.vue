<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <b-card header="Hotels">
                                    <br/>
                    <b-row>
                        <b-col lg="6" class="">
                            <b-input-group>
                                <b-input-group-button>
                                    <b-button>Go!</b-button>
                                </b-input-group-button>
                                <b-form-input type="text" placeholder="Search for hotel" />
                            </b-input-group>
                        </b-col>


                        <b-col lg="12" class="hotels">
                                <b-table class="table-outline table-responsive-sm mb-0" striped hover :items="items"></b-table>
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
        border:1px solid #f0f3f5;
    }
</style>