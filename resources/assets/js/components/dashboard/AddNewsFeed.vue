<template>
    <b-container fluid id="main-block">
        <b-row>
            <!--Main editor-->
            <b-col sm="12">
                <h3>Add Card</h3>
            </b-col>
            <b-col md="9">

                <b-form-group id="group-name"
                              label-for="type name here"
                              description="for identification purposes">
                    <b-form-input type="text"
                                  required
                                  v-model="cardName"
                                  placeholder="Name...">
                    </b-form-input>
                </b-form-group>

                <h5>Short description</h5>
                <div class="editor-div">
                <quill-editor
                        :options="editorOptions2"
                        v-model="description"
                ></quill-editor>
                </div>
                <br>

                <h5>Content</h5>
                <!--Editor-->
                <div class="editor-div">
                    <quill-editor
                            :options="editorOptions"
                            v-model="content"
                    ></quill-editor>
                </div>
            </b-col>
            <!--Main editor end-->


            <!--Buttons config-->
            <b-col md="3">

                <b-card header="Group Tags">
                    <br/>
                    <b-row>
                        <b-col v-if="fetchComplete" lg="12" class="mb-3">
                            <p>Select hotel tags</p>
                            <v-select :value.sync="selected" multiple :options="options"></v-select>
                        </b-col>
                        <div class="clearfix"></div>
                        <br/>
                    </b-row>

                </b-card>


                <b-card header="Publish">
                    <b-button @click="save('draft')" class="draft-button" variant="outline-secondary">Save as draft</b-button>
                    <b-button @click="save('preview')" class="preview-button" variant="outline-secondary">Preview</b-button>
                    <br/>

                        <br/>
                        <b-col sm="12">
                            <p> <i class="fa fa-paper-plane" aria-hidden="true"> </i>  Published: <span :style="{ color:publish.color }">  {{ publish.status}}</span> </p>
                        </b-col>

                    <b-col class="publish-footer">
                        <br>
                    <b-button class="cancel-button draft-button" variant="link">Discard</b-button>
                    <b-button @click="save('save')" type="submit" class="preview-button" variant="success">Save</b-button>
                    </b-col>
                </b-card>


                <b-card header="Media">

                    <b-form-fieldset
                            label="Header image"
                            description="Card image || optional"
                    >
                        <b-form-file
                                id="card-img"
                                label="img"
                                @change="imageChange"
                        ></b-form-file>
                    </b-form-fieldset>
                </b-card>


            </b-col>
            <!--Button configs end-->
        </b-row>
    </b-container>
</template>

<script>
    import {quillEditor} from 'vue-quill-editor';
    import vSelect from 'vue-select'

    export default {
        name: "AddNewsFeed",
        data() {
            return {
                editorOptions: {
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline', 'strike'],
                            ['blockquote', 'code-block'],
                            [{'header': 1}, {'header': 2}],
                            [{'list': 'ordered'}, {'list': 'bullet'}],
                            [{'script': 'sub'}, {'script': 'super'}],
                            [{'indent': '-1'}, {'indent': '+1'}],
                            [{'direction': 'rtl'}],
                            [{'size': ['small', false, 'large', 'huge']}],
                            [{'header': [1, 2, 3, 4, 5, 6, false]}],
                            [{'font': []}],
                            [{'color': []}, {'background': []}],
                            [{'align': []}],
                            ['clean'],
                            ['link']
                        ],
                    }
                },


                editorOptions2: {
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline', 'strike'],
                            ['blockquote', 'code-block'],
                            [{'header': 1}, {'header': 2}],
                            [{'list': 'ordered'}, {'list': 'bullet'}],
                            [{'script': 'sub'}, {'script': 'super'}],
                            [{'indent': '-1'}, {'indent': '+1'}],
                            [{'direction': 'rtl'}],
                            [{'size': ['small', false, 'large', 'huge']}],
                            [{'header': [1, 2, 3, 4, 5, 6, false]}],
                            [{'font': []}],
                            [{'color': []}, {'background': []}],
                            [{'align': []}],
                            ['clean'],
                            ['link']
                        ],
                    }
                },

                belongsTo:[],
                cardName:'',
                description:'',
                content: '',
                publish:{
                    status:'no',
                    color:'red',
                },


                options: [],
                searchText: '', // If value is falsy, reset searchText & searchItem
                selected:[],
                lastSelectItem: {},
                fetchComplete:false,
                imageUploaded:false,
                cardCreated:false,


            }
        },
        components: {
            quillEditor,
           vSelect
        },

        computed:{

        },

        mounted() {
            this.getData();
        },

        methods:{
            back(){
                console.log('Back')
            },
            imageChange(){
                this.imageUploaded=true
            },

            getData(){
                axios.get('/newsfeeds/cards/data')
                    .then(response => {
                        //this.loading = '';
                        this.fetchComplete = true;
                        this.options = response.data
                        this.options.push({ value:['all'], label:'all' })
                    })
                    .catch(e => {
                        this.errors = true;
                    });
            },


            save(param){
                if(param ==='save'){
                    let data = {
                        card_name:this.cardName,
                        published:'yes',
                        belongs_to:this.selected,
                        description:this.description,
                        feed_content:this.content
                    }

                    axios.post('/newsfeeds/cards/new', data)
                        .then(response => {
                            //this.lastID = response.data
                            //this.success = true
                            if(this.imageUploaded){
                                this.uploadImage(response.data);
                            }

                        })
                        .catch(e => {
                            this.errors = true;
                        });

                }

            },

            uploadImage(id) {

                var data = new FormData();
                data.append('cardimg', document.getElementById('card-img').files[0]);
                axios.post('/newsfeeds/media/' + id, data,
                )
                    .then(response => {
                        this.cardCreated = true;
                        setTimeout(() => {
                            return this.$router.push({name: 'Cards'})
                        }, 1000);
                    })
                    .catch(e => {
                        this.critError = true;

                    });
            },
        },


    }
</script>

<style>
    @import '~quill/dist/quill.core.css';
    @import '~quill/dist/quill.snow.css';

    .main-block {
        min-height: 100%;
        position: relative;
    }

    .editor-div {
        background: white;
    }

    .preview-button, .draft-button{
        margin-top: -5%;
        border-radius: 5px;
    }
    .preview-button{
        float: right;
    }
    .draft-button{
        float: left;
    }

    .save-button{
        float: right;
        border-radius: 5px;
        font-weight: 600;
    }
    .publish-footer{
        border-top:1px solid #c2cfd6 ;
    }
    .cancel-button{
        color: #ff463d;
    }
    .cancel-button:hover{
        color: red;
    }

    .ql-editor{
        min-height: 200px;
    }
</style>


