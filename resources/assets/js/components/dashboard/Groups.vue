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
                                <b-input-group>
                                    <b-input-group-button>
                                        <b-button variant="success"><i class="fa fa-search"></i></b-button>
                                    </b-input-group-button>
                                    <b-form-input v-model="filter" type="text" placeholder="Search for..."/>
                                    <b-input-group-button>
                                        <b-button variant="success">Search</b-button>
                                    </b-input-group-button>
                                </b-input-group>
                            </b-col>
                            <div class="clearfix"></div>
                            <br/>
                            <b-col v-if="fetchComplete" lg="12">
                                <b-col lg="4" class="groups"
                                       v-for="group in filteredList"
                                       :key="group.id"
                                >
                                    <!--Hotel blocks-->
                                    <b-card class="groups" bg-variant="dark" text-variant="white"
                                            :title="group.group_name">
                                        <p class="card-text">
                                            <span>{{ normalize(JSON.parse(group.group_tags)) }}</span>
                                        </p>
                                        <b-button @click="editGroup(group.id)" type="edit" variant="primary"><i
                                                class="fa fa-pencil-square-o"></i> Edit
                                        </b-button>
                                        <b-button @click="confirmDelete(group.id, group.group_name)" type="delete"
                                                  variant="danger"><i class="fa fa-ban"></i> Delete
                                        </b-button>
                                    </b-card>
                                </b-col>
                            </b-col>
                        </b-row>
                    </b-card>
                    <b-modal centered title="Warning" class="modal-danger" v-model="confirmDeleteAction"
                             @ok="deleteGroup()">
                        You are going to delete {{ deleteCreds.name }}. Press OK if you are sure!
                    </b-modal>
                    <b-modal centered title="Error" class="modal-danger" v-model="errors" hide-footer>
                        Oops~ something went terribly wrong!
                    </b-modal>
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
                filter: '',
                fetchComplete: false,
                groups: {},
                confirmDeleteAction: false,
                deleteCreds: {
                    id: null,
                    name: null,
                },
                errors:false,
            }
        },

        mounted() {
            this.getData();

        },

        computed: {
            filteredList() {
                return this.groups.filter(group => {
                    return group.group_name.toLowerCase().includes(this.filter.toLowerCase())
                })
            },
        },

        methods: {

            getData(){
                axios.get('/newsfeeds/groups')
                    .then(response => {
                        this.fetchComplete = true;
                        this.groups = response.data;
                    })
                    .catch(e => {
                        this.errors = true
                    });
            },


            normalize(obj) {
                return obj.toString();
            },

            editGroup(id) {
                this.$router.push({name: 'Edit group', params: {id: id}})
            },

            confirmDelete(id, name) {
                this.deleteCreds.id = id;
                this.deleteCreds.name = name;
                this.confirmDeleteAction = true
            },

            deleteGroup(){
                axios.delete('/newsfeeds/group/delete/' + this.deleteCreds.id)
                    .then(response => {
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