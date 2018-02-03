<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <b-card header="Email group">
                        <br/>
                        <b-row>
                            <b-col lg="1" class="mb-3">
                                <b-button @click="$router.push({name: 'Add Email list setting'})" variant="primary"><i
                                        class="fa fa-plus"></i> Add
                                </b-button>
                            </b-col>
                            <b-col offset="7" lg="3" class="mb-3">
                                <!--hotel-->
                                <b-input-group>
                                    <b-input-group-button>
                                        <b-button variant="primary"><i class="fa fa-search"></i></b-button>
                                    </b-input-group-button>
                                    <b-form-input v-model="filter" type="text" placeholder="Search by name"/>
                                    <b-input-group-button>
                                    </b-input-group-button>
                                </b-input-group>
                            </b-col>
                            <div class="clearfix"></div>
                            <br/>
                            <b-col v-if="fetchComplete" lg="12">
                                <b-col lg="4" class="groups"
                                       v-for="setting in filteredList"
                                       :key="setting.id"
                                >
                                    <!--Hotel blocks-->
                                    <b-card class="groups" bg-variant="dark" text-variant="white"
                                            :title="setting.name">
                                        <p class="card-text">
                                            <span>Included: {{ countHotels(setting.hotels) }}  hotels</span>
                                        </p>
                                        <b-button @click="editEmailSetting(setting.id)" type="edit" variant="primary"><i
                                                class="fa fa-pencil-square-o"></i> Edit
                                        </b-button>
                                        <b-button @click="confirmDelete(setting.id, setting.name)" type="delete"
                                                  variant="danger"><i class="fa fa-ban"></i> Delete
                                        </b-button>
                                    </b-card>
                                </b-col>
                            </b-col>
                        </b-row>
                    </b-card>
                    <b-modal centered title="Warning" class="modal-danger" v-model="confirmDeleteAction"
                             @ok="deleteSetting()">
                        You are going to delete {{ deleteCreds.name }}. Press OK if you are sure!
                    </b-modal>
                    <b-modal centered title="Error" class="modal-danger" v-model="errors" hide-footer>
                        Oops~ something went terribly wrong!
                    </b-modal>
                </div>
            </div>
        </div>
        <b-card header="NOTE:  Please send tokens to hotels">
            <b-col lg="12">
                <span>To download email please use one of this URLs:</span><br>
                <span><b>https://wifi.guestcompass.nl/emails</b></span><br>
                <p><b>https://wifi.guestcompass.nl/emails/{ TOKEN }</b></p>
                <span style="font-size: 10px">change { TOKEN } to actual token</span>
            </b-col>
        </b-card>

    </div>
</template>
<script>
    import {ModelSelect} from 'vue-search-select'

    export default {
        name: 'EmailSetting',
        components: {
            ModelSelect,

        },
        data: function () {
            return {
                filter: '',
                fetchComplete: false,
                settings: [],
                confirmDeleteAction: false,
                deleteCreds: {
                    id: null,
                    name: null,
                },
                errors: false,
            }
        },

        mounted() {
            this.getData();

        },

        computed: {
            filteredList() {
                return this.settings.filter(setting => {
                    return setting.name.toLowerCase().includes(this.filter.toLowerCase())
                })
            },
        },

        methods: {

            countHotels(str) {
                let a = (JSON.parse(str))
                return a.length
            },

            getData() {
                axios.get('/settings/emails')
                    .then(response => {
                        if (response.data.length > 0) {
                            let process = response.data;
                            process.forEach(element => {
                                this.settings.push(
                                    {
                                        id: element.id,
                                        name: JSON.parse(element.setting).name,
                                        hotels: JSON.parse(element.setting).hotels
                                    }
                                )
                            })
                            this.fetchComplete = true
                        } else {
                            return;
                        }
                    })
                    .catch(e => {
                        this.errors = true
                    });
            },

            editEmailSetting(id) {
                this.$router.push({name: 'Edit Email list setting', params: {id: id}})
            },

            confirmDelete(id, name) {
                this.deleteCreds.id = id;
                this.deleteCreds.name = name;
                this.confirmDeleteAction = true
            },

            deleteSetting() {
                axios.delete('/settings/delete/' + this.deleteCreds.id)
                    .then(response => {
                        this.settings = [];
                        this.getData();
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

</style>