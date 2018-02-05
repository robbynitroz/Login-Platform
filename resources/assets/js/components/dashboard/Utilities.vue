<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <b-card no-body>
                        <div class="card-header">
                            <div> Database utilization % &nbsp;&nbsp;
                                <c-switch type="text" variant="success" on="On" off="Off"
                                          @change="swither()" :checked="on"/>
                                <b-button @click="setData()" variant="primary save-button"> Save</b-button>
                            </div>
                        </div>
                        <br/>
                        <div class="raw" v-if="on">
                            <b-col lg="12" class="mb-3 text-center">
                                <h3 class="percent">{{ percentage }}%</h3>
                            </b-col>
                            <div class="clearfix"></div>
                            <br/>
                            <b-col lg="12">
                                <b-form-fieldset>
                                    <b-input-group
                                            left="<i class='fa fa-minus'></i>"
                                            right="<i class='fa fa-plus'></i>">
                                        <b-form-input type="range" step="5" min="10" max="90" v-model="percentage"
                                                      value="getGreatingSize" class="slider"></b-form-input>
                                    </b-input-group>
                                </b-form-fieldset>
                            </b-col>
                        </div>
                    </b-card>
                    <b-modal centered title="Error" class="modal-danger" v-model="errors" hide-footer>
                        Oops~ something went terribly wrong!
                    </b-modal>
                    <b-modal size="sm" centered title="Success" class="modal-success" v-model="success" hide-footer>
                        <div class="d-block text-center">
                            <h3>SAVED!</h3>
                        </div>
                    </b-modal>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {ModelSelect} from 'vue-search-select'
    import cSwitch from './additional-components/Switch.vue'

    export default {
        name: 'Utilities',
        components: {
            ModelSelect,
            cSwitch,

        },
        data: function () {
            return {
                fetchComplete: false,
                percentage: 50,
                on: false,
                errors: false,
                success: false,
            }
        },

        mounted() {
            this.getData();

        },

        computed: {},

        methods: {

            swither() {
                this.on = !this.on
            },

            setData() {
                axios.post('/settings/utilisation/set', {
                    on: this.on,
                    percent: this.percentage,
                }).then(response => {
                    this.success = true;
                })
                    .catch(e => {
                        this.errors = true
                    });
            },

            getData() {
                axios.get('/settings/utilisation')
                    .then(response => {
                        this.on = response.data.on;
                        this.percentage = response.data.percent;
                    })
                    .catch(e => {
                        this.errors = true
                    });
            },
        }
    }

</script>
<style scoped>

    .groups {
        border-radius: 10px;
        float: left;
        width: 100%;
    }

    .hotel-logo {
        position: absolute;
        top: 5px;
        right: 10px;
    }

    .form-control {
        margin-left: -1px;
    }

    .slider {
        -webkit-appearance: none;
        width: 100%;
        height: 25px;
        background: linear-gradient(to right, yellow, green, red);
        outline: none;
        opacity: 0.7;
        -webkit-transition: .2s;
        transition: opacity .2s;
    }

    .slider:hover {
        opacity: 1;
    }

    .slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 25px;
        height: 25px;
        background: #4CAF50;
        cursor: pointer;
    }

    .slider::-moz-range-thumb {
        width: 25px;
        height: 25px;
        background: #4CAF50;
        cursor: pointer;
    }

    .percent {
        margin-bottom: -1.5rem !important;
    }

    .save-button {
        float: right;
    }

</style>