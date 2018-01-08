<template>
    <div class="wrapper">

        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <b-card header="Groups">
                        <br/>
                        <b-row>
                            <b-col offset="9" lg="3" class="mb-3">
                                <h5>Search in groups</h5>
                                <!--hotel-->

                                <model-select :options="[1,2,3]"
                                              v-model="filter"
                                              placeholder="select Hotel">
                                </model-select>


                            </b-col>

                            <div class="clearfix"></div>
                            <br/>

                        </b-row>
                    </b-card>
                </div>
            </div>
                </div>
            </div>

</template>

<script>
    import {ModelSelect} from 'vue-search-select'


    export default {
        name: 'Groups',
        components: {
            ModelSelect,

        },
        data: function () {
            return {
                filter:{},
            }
        },

        mounted() {

        },

        computed: {},

        methods: {}
    }

</script>
<style scoped>
    .search{
        float: right;
    }



</style>