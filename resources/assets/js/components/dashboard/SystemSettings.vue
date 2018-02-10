<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <b-card no-body>
                        <div class="card-header">
                            <div> Server management &nbsp;&nbsp;
                            </div>
                        </div>
                        <br/>
                        <div class="raw">
                            <b-button @click="confirmRadius = ! confirmRadius" class="restart-radius" size="lg"
                                      variant="primary"> Restart FreeRadius server
                            </b-button>
                            <b-button @click="confirmServer = ! confirmServer" class="restart-server" size="lg"
                                      variant="danger">
                                <b>
                                    BIG RED <br>
                                    BUTTON</b>
                            </b-button>
                            <div class="clearfix"></div>
                            <br/>
                        </div>
                    </b-card>
                    <b-modal centered title="Warning" class="modal-danger" v-model="confirmServer"
                             @ok="serverRequest('reboot')">
                        SERVER WILL BE REBOOTED!!! Press OK if you are sure!
                    </b-modal>
                    <b-modal centered title="Warning" class="modal-warning" v-model="confirmRadius"
                             @ok="serverRequest('freeradius')">
                        FreeRaduis server will be restarted! Press OK if you are sure!
                    </b-modal>
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

    export default {
        name: 'SystemSettings',
        components: {},
        data: function () {
            return {
                errors: false,
                success: false,
                confirmServer: false,
                confirmRadius: false
            }
        },
        computed: {},
        methods: {
            serverRequest(param) {
                this.confirmServer = false;
                this.confirmRadius = false
                axios.post('/settings/management', {
                    action: param,
                }).then(response => {
                    this.success = true;
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

    .restart-radius {
        margin: 3%;
    }

    .restart-server {
        height: 200px;
        width: 200px;
        border-radius: 50%;
        font-size: 30px;
        margin-left: 16%;
    }
</style>