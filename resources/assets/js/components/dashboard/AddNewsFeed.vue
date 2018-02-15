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
                                  @change="nameFiiled"
                                  required
                                  v-model="cardName"
                                  placeholder="Name...">
                    </b-form-input>
                </b-form-group>
                <h5>Text on the card</h5>
                <div class="editor-div">
                    <quill-editor
                            :options="editorOptions2"
                            v-model="description"
                    ></quill-editor>
                </div>
                <br>
                <h5>Text on the back of the card</h5>
                <!--Editor-->
                <div class="editor-div">
                    <quill-editor
                            :options="editorOptions"
                            v-model="feedContent"
                    ></quill-editor>
                </div>
                <br>
                <div role="group">
                    <label for="buttonText">Text on the button</label>
                    <b-form-input id="buttonText"
                                  v-model="buttonText"
                                  type="text"
                                  aria-describedby=""
                                  placeholder="Text..."></b-form-input>
                    <br>
                    <label for="buttonLink">URL or Email address</label>
                    <b-form-input id="inputLive"
                                  v-model="buttonLink"
                                  type="text"
                                  aria-describedby=""
                                  placeholder="URL or email"></b-form-input>
                    <b-form-text id="inputLiveHelp">
                        <!-- this is a form text block (formerly known as help block) -->
                        don't forget to putt 'mailto:' before email address
                    </b-form-text>
                </div>
                <br>
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
                    <b-button @click="save('draft')" class="draft-button" variant="outline-secondary">Save as draft
                    </b-button>
                    <b-button @click="save('preview')" class="preview-button" variant="outline-secondary">Preview
                    </b-button>
                    <br/>
                    <br/>
                    <b-col sm="12">
                        <p><i class="fa fa-paper-plane" aria-hidden="true"> </i> Published: <span
                                :style="{ color:publish.color }">  {{ publish.status}}</span></p>
                    </b-col>
                    <b-col class="publish-footer">
                        <br>
                        <b-button class="cancel-button draft-button" variant="link">Discard</b-button>
                        <template v-if="showSave">
                            <b-button @click="save('save')" type="submit" class="preview-button" variant="success">
                                Save
                            </b-button>
                        </template>
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
            <!--Modal here-->
            <b-modal centered title="Error" class="modal-danger" v-model="errors" hide-footer>
                Oops~ something went terribly wrong!
            </b-modal>
            <b-modal size="sm" centered title="Success" class="modal-success" v-model="cardCreated" hide-footer>
                <div class="d-block text-center">
                    <h3>SAVED!</h3>
                </div>
            </b-modal>
            <b-modal
                    no-close-on-backdrop
                    no-close-on-esc
                    hide-footer
                    hide-header
                    hide-header-close
                    size="sm"
                    ok-disabled
                    cancel-disabled
                    v-model="loading"
                    centered title="Bootstrap-Vue">
                <div class="text-center center-block loading-modal">
                    <p style="color: #00aced; font-size: 2.2rem; font-weight: 900" class="my-4">{{
                        completed }}%</p>
                </div>
            </b-modal>
        </b-row>
    </b-container>
</template>

<script>
    import {quillEditor} from 'vue-quill-editor';
    import vSelect from 'vue-select'
    import {newsfeedCard} from '../../mixins/newsfeedCard';

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
                belongsTo: [],
                cardName: '',
                description: '',
                feedContent: '',
                publish: {
                    status: 'no',
                    color: 'red',
                },
                buttonText: '',
                buttonLink: '',
                options: [],
                searchText: '', // If value is falsy, reset searchText & searchItem
                selected: [],
                lastSelectItem: {},
                fetchComplete: false,
                imageUploaded: false,
                cardCreated: false,
                errors: false,
                showSave: false,
                completed: 0,
            }
        },
        components: {
            quillEditor,
            vSelect
        },

        computed: {},

        mounted() {
            this.getData();
        },

        methods: {

            imageChange() {
                this.imageUploaded = true
            },

            nameFiiled() {
                this.showSave = true
            },
            getData() {
                axios.get('/newsfeeds/cards/data')
                    .then(response => {
                        this.fetchComplete = true;
                        this.options = response.data
                        this.options.push({label: 'All', value: ['all']})
                    })
                    .catch(e => {
                        this.errors = true;
                    });
            },
        },

        mixins: [
            newsfeedCard
        ],
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

    .preview-button, .draft-button {
        margin-top: -5%;
        border-radius: 5px;
    }

    .preview-button {
        float: right;
    }

    .draft-button {
        float: left;
    }

    .save-button {
        float: right;
        border-radius: 5px;
        font-weight: 600;
    }

    .publish-footer {
        border-top: 1px solid #c2cfd6;
    }

    .cancel-button {
        color: #ff463d;
    }

    .cancel-button:hover {
        color: red;
    }

    .ql-editor {
        min-height: 200px;
    }
</style>


