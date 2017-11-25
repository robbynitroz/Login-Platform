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


            }
        },
        methods: {

        }
    }
</script>