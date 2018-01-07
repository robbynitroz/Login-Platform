<template>
    <b-container fluid id="main-block">
        <b-row>
            <!--Main editor-->
            <b-col sm="12">
                <h3>Add group</h3>
            </b-col>
            <b-col md="9">

                <b-form-group id="group-name"
                              label-for="type name here"
                              description="for identification purposes">
                    <b-form-input type="text"
                                  required
                                  placeholder="Name...">
                    </b-form-input>
                </b-form-group>

                <b-form-group id="group-desc"
                              label-for="description"
                              description="short description of newsfeed">
                    <b-form-input type="text"
                                  required
                                  placeholder="Description...">
                    </b-form-input>
                </b-form-group>

                <!--Editor-->
                <div class="editor-div">
                    <quill-editor
                            :options="editorOptions"
                    ></quill-editor>
                </div>
            </b-col>
            <!--Main editor end-->


            <!--Buttons config-->
            <b-col md="3">

                <b-card header="Hotel Tags">
                    <br/>
                    <b-row>
                        <b-col lg="12" class="mb-3">
                            <p>Input hotel names, push enter to divide</p>
                            <input-tag placeholder="hotel names" :tags="belongsTo"></input-tag>
                        </b-col>
                        <div class="clearfix"></div>
                        <br/>
                    </b-row>
                </b-card>

                <b-card header="Publish">
                    <b-button class="draft-button" variant="outline-secondary">Save as draft</b-button>
                    <b-button class="preview-button" variant="outline-secondary">Preview</b-button>
                    <br/>

                    <b-row>
                        <div class="clearfix"></div>
                        <br/>
                        <b-col>
                            123
                        </b-col>
                    </b-row>
                </b-card>


            </b-col>
            <!--Button configs end-->
        </b-row>
    </b-container>
</template>

<script>
    import {quillEditor} from 'vue-quill-editor';
    import InputTag from 'vue-input-tag';

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
                belongsTo:[],
                content: '',

            }
        },
        components: {
            quillEditor,
            InputTag
        }
    }
</script>

<style>
    @import '~quill/dist/quill.core.css';
    @import '~quill/dist/quill.snow.css';
    @import '~quill/dist/quill.bubble.css';

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

</style>

