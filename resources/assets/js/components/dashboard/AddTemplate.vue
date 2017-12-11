<template>
    <div class="wrapper">

        <div class="animated fadeIn">

            <div v-if="hotelsFetchComplete && methodsFetchComplete" class="row">

                <div class="col-md-12">
                    <form enctype="multipart/form-data" @submit.prevent="save()">
                        <b-card>
                            <div slot="header">
                                <strong>Add Template</strong>
                            </div>


                            <!--hotel-->
                            <b-form-fieldset label="Select hotel"
                                             description="which one of hotels this template belongs to ?">
                                <select v-model="hotelID" class="form-control custom-select">
                                    <option v-for="(hotel, key) in hotels" :value="hotel.id">{{ hotel.name }}</option>
                                </select>
                            </b-form-fieldset>

                            <!--template type / login method-->
                            <b-form-fieldset label="Select method"
                                             description="which one method should this template use ?">
                                <select v-model="defaultComponent" class="form-control custom-select">
                                    <option v-for="method in methods" :value="method">{{ method }}</option>
                                </select>
                            </b-form-fieldset>

                            <hr>

                            <div v-if="changeStatus">
                                <h3>Required images</h3>
                                <!--Hotel logo-->
                                <b-form-fieldset
                                        label="Logo input"
                                        description="Upload Hotel logo || required"
                                        required
                                >
                                    <b-form-file
                                            id="logo"
                                            label="Logo input"
                                            @change="imageChange"
                                            required
                                    ></b-form-file>
                                </b-form-fieldset>


                                <!--Background picture or video-->
                                <b-form-fieldset
                                        label="Template background"
                                        description="Background picture or video || required"
                                        required
                                >
                                    <b-form-file
                                            id="background"
                                            label="Packground picture"
                                            @change="imageChange"
                                            required
                                    ></b-form-file>
                                </b-form-fieldset>


                                <hr>

                                <h3>Required texts</h3>


                                <!--Template texts-->
                                <div>
                                    <b-tabs>
                                        <template v-for="lang in langs">
                                            <b-tab :title="addLangs[lang]">
                                                <b-form-fieldset
                                                        label="Enter text in language of the tab, all fields are required"
                                                        description="NOTE:  All fields above are required!!!">
                                                    <!--greetingText-->
                                                    <b-form-fieldset>
                                                        <b-input-group left="<i class='fa fa-home'></i>">
                                                            <b-form-input type="text"
                                                                          required
                                                                          v-model="texts[lang].greetingText"
                                                                          placeholder="Heading text"></b-form-input>
                                                        </b-input-group>
                                                    </b-form-fieldset>

                                                    <!--button text-->
                                                    <b-form-fieldset>
                                                        <b-input-group left="<i class='fa fa-bars'></i>">
                                                            <b-form-input type="text"
                                                                          required
                                                                          v-model="texts[lang].buttonText"
                                                                          placeholder="Login/Email button text"></b-form-input>
                                                        </b-input-group>
                                                    </b-form-fieldset>


                                                    <!--Email text-->
                                                    <b-form-fieldset v-if="showSomeField">
                                                        <b-input-group left="<i class='fa fa-envelope'></i>">
                                                            <b-form-input type="text"
                                                                          required
                                                                          v-model="texts[lang].emailText"
                                                                          placeholder="Email heading text"></b-form-input>
                                                        </b-input-group>
                                                    </b-form-fieldset>


                                                    <!--Little text text-->
                                                    <b-form-fieldset v-if="defaultComponent =='Login'">
                                                        <b-input-group left="<i class='fa fa-podcast'></i>">
                                                            <b-form-input type="text"
                                                                          required
                                                                          v-model="texts[lang].littleText"
                                                                          placeholder="Little text under button"></b-form-input>
                                                        </b-input-group>
                                                    </b-form-fieldset>

                                                    <hr>
                                                    <p>Terms and Conditions settings</p>


                                                    <!--policyText text-->
                                                    <b-form-fieldset>
                                                        <b-input-group left="<i class='fa fa-question-circle'></i>">
                                                            <b-form-input type="text"
                                                                          required
                                                                          v-model="texts[lang].policyText"
                                                                          placeholder="Terms and condition text"></b-form-input>
                                                        </b-input-group>
                                                    </b-form-fieldset>


                                                    <!--policy link text-->
                                                    <b-form-fieldset>
                                                        <b-input-group left="<i class='fa fa-question-circle'></i>">
                                                            <b-form-input type="text"
                                                                          required
                                                                          v-model="texts[lang].policyLinkText"
                                                                          placeholder="Terms link text, almost always - Terms & Condition"></b-form-input>
                                                        </b-input-group>
                                                    </b-form-fieldset>


                                                    <!--Go back from terms and conditions page links text-->
                                                    <b-form-fieldset>
                                                        <b-input-group left="<i class='fa fa-question-circle'></i>">
                                                            <b-form-input type="text"
                                                                          required
                                                                          v-model="texts[lang].policyBackLinkText"
                                                                          placeholder="Go back from terms and conditions page links text"></b-form-input>
                                                        </b-input-group>
                                                    </b-form-fieldset>


                                                    <div v-if='sayTime'>
                                                        <hr>
                                                        <p>
                                                            Enter greeting for every time period || Note: You can leave default</p>

                                                        <!--morining-->
                                                        <b-form-fieldset>
                                                            <b-input-group left="<i class='fa fa-sun-o'></i>">
                                                                <b-form-input type="text"
                                                                              required
                                                                              v-model="texts[lang].sayTimeMorning"
                                                                              placeholder="Morning"></b-form-input>
                                                            </b-input-group>
                                                        </b-form-fieldset>

                                                        <!--Afternoon-->
                                                        <b-form-fieldset>
                                                            <b-input-group left="<i class='fa fa-cloud'></i>">
                                                                <b-form-input type="text"
                                                                              required
                                                                              v-model="texts[lang].sayTimeAfternoon"
                                                                              placeholder="Afternoon"></b-form-input>
                                                            </b-input-group>
                                                        </b-form-fieldset>

                                                        <!--Evening-->
                                                        <b-form-fieldset>
                                                            <b-input-group left="<i class='fa fa-moon-o'></i>">
                                                                <b-form-input type="text"
                                                                              required
                                                                              v-model="texts[lang].sayTimeEvening"
                                                                              placeholder="Evening"></b-form-input>
                                                            </b-input-group>
                                                        </b-form-fieldset>


                                                    </div>

                                                </b-form-fieldset>

                                            </b-tab>
                                        </template>
                                    </b-tabs>

                                </div>

                                <!--Add language button-->

                                <div>
                                    <b-dropdown id="ddown-buttons" text="Add languages"
                                                class="m-2">
                                        <template v-for="(lang, key) in addLangs">
                                            <b-dropdown-item-button @click="addLanguage(key)">{{ lang }}
                                            </b-dropdown-item-button>
                                        </template>
                                    </b-dropdown>
                                </div>
                                <b-alert v-model="langWanring" dismissible show variant="warning">
                                    Language have been already added to list
                                </b-alert>

                                <hr>


                                <h3>Required color settings and button colors</h3>


                                <div>
                                    <a href="" @click.prevent="storeColor('buttonBCK')">Button background color || </a>
                                    <a href="" @click.prevent="storeColor('buttonText')">Button text color || </a>
                                    <a href="" @click.prevent="storeColor('buttonHoverText')">Button text color on hover || </a>
                                    <a href="" @click.prevent="storeColor('buttonHoverBack')">Button background on hover || </a>
                                    <a href="" @click.prevent="storeColor('buttonBorder')">Button border || </a>
                                    <a href=""
                                       @click.prevent="storeColor('buttonBorderHover')">Button border on hover </a>
                                </div>

                                <button
                                        type="button"
                                        :style="buttonStyleObject"
                                        @mouseenter='updateHoverState(true)'
                                        @mouseleave="updateHoverState(false)"
                                        class="btn btn-outline-info large-button text-center"><i
                                        class='fa fa-sign-in'></i> {{ texts.en.buttonText }}
                                </button>


                                <br>

                                <hr>

                                <br>

                                <h4> Greeting text </h4>

                                <div>
                                    <a href=""
                                       @click.prevent="storeColor('policy')">
                                        Terms aka Policy link and text color  || </a>
                                    <a href=""
                                       @click.prevent="storeColor('greeting')"> Greeting or text on the top  || </a>
                                    <a v-if="defaultComponent =='Login'" href=""
                                       @click.prevent="storeColor('littleTextColor')">
                                        Little text under login button  </a>

                                </div>
                                <br>
                                <hr>
                                <br>
                                <h4> Background color </h4>
                                <div>
                                    <a href="" @click.prevent="storeColor('background')">
                                        Background color (transparency allowed)  </a>
                                </div>
                                <br>
                                <div class="demo-div" :style="backgroundColor"></div>
                                <br>
                                <hr>
                                <br>


                                <h4> Text sizes  </h4>
                                <div>

                                </div>


                                <p> Greeting text size - <span style="color: #bb0000"> {{ greeting.size }} </span></p>
                                <b-form-fieldset>
                                    <b-input-group
                                            left="<i class='fa fa-minus'></i>"
                                            right="<i class='fa fa-plus'></i>"
                                    >
                                        <b-form-input type="range" min="1" max="50" v-model="getGreatingSize"
                                                      value="getGreatingSize" class="slider"></b-form-input>
                                    </b-input-group>
                                </b-form-fieldset>
                                <br>

                                <template v-if="sayTime">
                                    <p> Greeting time text size- <span style="color: #bb0000"> {{ greetingsTime.size
                                        }} </span></p>
                                    <b-form-fieldset>
                                        <b-input-group
                                                left="<i class='fa fa-minus'></i>"
                                                right="<i class='fa fa-plus'></i>"
                                        >
                                            <b-form-input type="range" min="1" max="50" v-model="getTimeSize"
                                                          value="getTimeSize" class="slider"></b-form-input>
                                        </b-input-group>
                                    </b-form-fieldset>
                                    <br>
                                </template>
                                <p> Terms (Policy) text and link size- <span style="color: #bb0000"> {{ policy.size
                                    }} </span></p>
                                <b-form-fieldset>
                                    <b-input-group
                                            left="<i class='fa fa-minus'></i>"
                                            right="<i class='fa fa-plus'></i>"
                                    >
                                        <b-form-input type="range" min="1" max="50" v-model="getPolicySize"
                                                      value="getPolicySize" class="slider"></b-form-input>
                                    </b-input-group>
                                </b-form-fieldset>
                                <br>
                                <hr>
                                <br>


                                <h4> Options </h4>
                                <br>
                                <div class="col-md-12">

                                    <b-card class="text-center fix-margin" header="Show Time greeting">
                                        <c-switch type="text" variant="success" on="On" off="Off"
                                                  @change="changeTimeGreeting()" :checked="greetingsTime.on"/>
                                    </b-card>


                                    <b-card v-if="dependOnComponent('emailOnly')" class="text-center fix-margin"
                                            header="Sign up via Email along with FB">
                                        <c-switch type="text" variant="success" on="On" off="Off"
                                                  @change="changeEmailState()" :checked="requireEmail"/>
                                    </b-card>

                                    <b-card v-if="dependOnComponent('fullName')" class="text-center fix-margin"
                                            header="Require Full name from user">
                                        <c-switch type="text" variant="success" on="On" off="Off"
                                                  @change="changeNameState()" :checked="requireName"/>
                                    </b-card>

                                    <b-card class="text-center fix-margin"
                                            header="Scheduled template">
                                        <c-switch type="text" variant="primary" on="On" off="Off"
                                                  @change="scheduleSwitcher()" :checked="schedule"/>
                                    </b-card>


                                    <!--/.col-->
                                </div>

                                <div class="clearfix"></div>

                                <b-alert v-model="schedule" dismissible show variant="primary">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    Schedule function enabled for this template
                                </b-alert>
                                <br>

                                <hr>

                                <br>

                                <template v-if="schedule">
                                    <h4>Schedule time</h4>
                                    <br>
                                    <p>Format: <i> Day-Month-Year || Hours:Min:Secs </i></p>

                                    <p>{{ timestamp(scheduleTime) }}</p>
                                    <date-picker v-model="scheduleTime"
                                                 type="datetime"
                                                 range
                                                 format="dd-MM-yyyy HH:mm:ss"
                                                 placeholder="Select time and date"
                                                 :shortcuts="shortcuts"
                                                 lang="en"></date-picker>


                                    <br>

                                    <hr>
                                </template>

                                <br>

                                <div slot="footer">
                                    <b-button
                                            type="submit"
                                            variant="success"><i
                                            class="fa fa-floppy-o"></i>
                                        Save
                                    </b-button>
                                    <b-button
                                            @click="save('preview')"
                                            type="button"
                                            variant="primary"><i
                                            class="fa fa-adjust"></i>
                                        Preview
                                    </b-button>
                                    <b-button
                                            :to="{name:'All templates'}"
                                            variant="danger">
                                        <i class="fa fa-ban"></i> Discard
                                    </b-button>
                                </div>
                            </div>
                        </b-card>
                    </form>


                </div>


            </div><!--/.col-->


            <!--Ends here-->


        </div><!--/.col-->


        <b-modal centered title="Critical error" class="modal-danger" v-model="critError" hide-footer>
            Please contact your webmaster or support
        </b-modal>


        <b-modal centered v-model="templateCreated" class="modal-success" size="sm" hide-footer title="Success">
            <div class="d-block text-center">
                <h3>Template  successfully created </h3>
            </div>
        </b-modal>


        <b-modal centered v-model="colorPicker"
                 size="sm"
                 hide-footer
                 hide-header
                 title="Pick up a color"

        >
            <b-container
                    fluid
                    :style="{ background:'rgba('+
                            colors.rgba.r + ','+ colors.rgba.g + ','
                            + colors.rgba.b + ',' + colors.rgba.a + ')',
                             }"
            >
                <div class="color-modal">
                    <sketch v-model="colors" @change-color="colorChange"></sketch>
                </div>

                <b-btn class="mt-3 button-close-picker" @click="colorSelected(forSection)" data-dismiss="modal"
                       variant="primary" block>OK
                </b-btn>
                <hr>
            </b-container>

        </b-modal>


    </div>


</template>

<script>
    import {Sketch} from 'vue-color'
    import cSwitch from './additional-components/Switch.vue'
    import DatePicker from 'vue2-datepicker'

    export default {
        name: 'AddTemplate',

        data: function () {
            return {

                colorPicker: false,
                forSection: '',

                hotels: {},
                hotelID: '',
                methods: [],
                texts: {
                    en: {
                        greetingText: '',
                        emailText: '',
                        buttonText: '',
                        policyText: '',
                        policyLinkText: '',
                        policyBackLinkText: '',
                        sayTimeEvening: 'Good evening!',
                        sayTimeMorning: 'Good morning!',
                        sayTimeAfternoon: 'Good afternoon!',
                        littleText: 'connect and proceed to our webapp',
                    }
                },

                requireName: false,

                requireEmail: true,

                langs: [
                    'en',
                ],
                addLangs: {
                    en: 'English',
                    nl: "Dutch",
                    de: "German",
                    fr: 'French',
                    es: 'Spanish',
                    zh: 'Chinese',
                    ru: 'Russian',
                    ar: 'Arabic',
                },

                button: {
                    color: '#d3e0ff',
                    colorBackd: '#1e2021',
                    colorHover: '#ffffff',
                    hoverState: false,
                    borderColor: '#d3e0ff',
                    colorBackdHover: '#000000',
                    borderColorHover: '#ffffff',
                },

                policy: {
                    size: '1rem',
                    color: '#d3e0ff',
                },

                greeting: {
                    size: '2.0rem',
                    color: '#ffffff',
                },

                hotelLogo: '',

                greetingsTime: {
                    on: false,
                    size: '2.4rem',
                    color: 'white',
                },

                activeComponent: false,
                defaultComponent: '', //Must be same as activeComponent

                backgroundColor: '',

                littleTextColor: '',

                media: {
                    src: '',
                    type: '',
                },


                critError: false,
                templateCreated: false,
                logoUploaded: false,
                logo: '',
                uploadButton: false,
                hotelsFetchComplete: false,
                methodsFetchComplete: false,
                langWanring: false,


                colors: {
                    hex: '#194d33',
                    rgba: {
                        r: 25,
                        g: 77,
                        b: 51,
                        a: 1
                    },

                },


                schedule: false,
                scheduleTime: '',
                startTime: '',
                endTime: '',

                shortcuts: [
                    {
                        text: 'Today',
                        start: new Date(),
                        end: new Date()
                    }
                ],

                preview:false,


            }


        },

        components: {
            Sketch,
            cSwitch,
            DatePicker
        },

        mounted() {


            axios.get('/template/methods')
                .then(response => {
                    this.hotels = response.data.hotels;
                    this.methods = response.data.methods;
                    this.methodsFetchComplete = true;
                    this.hotelsFetchComplete = true;
                })
                .catch(e => {
                    this.critError = true;
                });

        },


        computed: {

            sayTime() {
                return this.greetingsTime.on;
            },


            getGreatingSize: {
                //getter
                get: function () {

                    var rez = this.greeting.size.slice(0, 3);
                    if (typeof rez != "Nan") {
                        var rez = parseFloat(rez);
                    }
                    return rez * 10;

                },
                // setter
                set: function (newSize) {
                    this.greeting.size = newSize / 10 + 'rem';
                }
            },

            getTimeSize: {
                //getter
                get: function () {

                    var rez = this.greetingsTime.size.slice(0, 3);
                    if (typeof rez != "Nan") {
                        var rez = parseFloat(rez);
                    }
                    return rez * 10;

                },
                // setter
                set: function (newSize) {
                    this.greetingsTime.size = newSize / 10 + 'rem';
                }
            },


            getPolicySize: {
                //getter
                get: function () {

                    var rez = this.policy.size.slice(0, 3);
                    if (typeof rez != "Nan") {
                        var rez = parseFloat(rez);
                    }
                    return rez * 10;

                },
                // setter
                set: function (newSize) {
                    this.policy.size = newSize / 10 + 'rem';
                }
            },

            showSomeField() {
                if (this.defaultComponent == 'Facebook' || this.defaultComponent == 'Email') {
                    return true
                }
                return false;
            },

            changeStatus() {
                if (this.defaultComponent !== '') {
                    this.activeComponent = this.defaultComponent;
                    return true
                }
                return this.activeComponent
            },


            buttonStyleObject() {
                var modifier = '';
                if (this.button.hoverState)
                    modifier = 'Hover';

                return {
                    color: this.button['color' + modifier],
                    backgroundColor: this.button['colorBackd' + modifier],
                    borderColor: this.button['borderColor' + modifier]
                };
            },

        },

        methods: {


            timestamp(time) {
                if (typeof time == 'object') {
                    this.startTime = time[0].getTime();
                    this.endTime = time[1].getTime();
                }
            },


            colorSelected(section) {
                this.colorPicker = false;
                if (section == 'buttonBCK') {
                    this.button.colorBackd = this.colors.hex
                } else if (section == 'buttonText') {
                    this.button.color = this.colors.hex
                } else if (section == 'buttonHoverText') {
                    this.button.colorHover = this.colors.hex
                } else if (section == 'buttonHoverBack') {
                    this.button.colorBackdHover = this.colors.hex
                } else if (section == 'buttonBorder') {
                    this.button.borderColor = this.colors.hex
                } else if (section == 'buttonBorderHover') {
                    this.button.borderColorHover = this.colors.hex
                } else if (section == 'background') {
                    this.backgroundColor = 'background:rgba(' +
                        this.colors.rgba.r + ',' + this.colors.rgba.g + ','
                        + this.colors.rgba.b + ',' + this.colors.rgba.a + ')'
                } else if (section == 'termsColor') {
                    this.policy.color = this.colors.hex
                } else if (section == 'greeting') {
                    this.greeting.color = this.colors.hex
                } else if (section == 'littleTextColor') {
                    this.littleTextColor = this.colors.hex
                }
            },

            changeTimeGreeting() {
                this.greetingsTime.on = !this.greetingsTime.on
            },
            changeEmailState() {
                this.requireEmail = !this.requireEmail
            },

            changeNameState() {
                this.requireName = !this.requireName
            },

            scheduleSwitcher() {
                this.schedule = !this.schedule
            },

            dependOnComponent(component) {
                if (this.activeComponent == 'Login') {
                    return false;
                } else if (this.activeComponent == 'Email' && component == 'fullName') {
                    return true;
                } else if (this.activeComponent == 'Facebook' && component == 'emailOnly') {
                    return true;
                } else if (this.activeComponent == 'Facebook' && component == 'fullName' && this.requireEmail == true) {
                    return true;
                }
            },


            addLanguage(lang) {

                this.langWanring = false;
                if (typeof this.texts[lang] === 'undefined') {

                    var newObj = {
                        greetingText: '',
                        emailText: '',
                        buttonText: '',
                        policyText: '',
                        policyLinkText: '',
                        policyBackLinkText: '',
                        sayTimeEvening: 'Good evening!',
                        sayTimeMorning: 'Good morning!',
                        sayTimeAfternoon: 'Good afternoon!',
                        littleText: 'connect and proceed to our webapp',
                    }

                    this.$set(this.texts, lang, newObj)
                    this.langs.push(lang);
                } else {
                    this.langWanring = true
                }

            },

            updateHoverState(isHover) {
                this.button.hoverState = isHover;
            },


            storeColor(id) {
                this.colorPicker = true;
                this.forSection = id;
            },

            colorChange(val) {
                this.colors = val
            },

            imageChange() {
                this.logoUploaded = true
            },

            save(preview='') {

                if(preview==='preview'){
                    var url='/template/preview'
                } else {
                    var url='/template/add'
                }

                axios.post(url, {
                    hotelID: this.hotelID,
                    texts: this.texts,
                    langs: this.langs,
                    requireName: this.requireName,
                    requireEmail: this.requireEmail,
                    button: this.button,
                    policy: this.policy,
                    greeting: this.greeting,
                    hotelLogo: this.hotelLogo,
                    greetingsTime: this.greetingsTime,
                    activeComponent: this.activeComponent,
                    defaultComponent: this.activeComponent,
                    backgroundColor: this.backgroundColor,
                    littleTextColor: this.littleTextColor,
                    schedule: this.schedule,
                    startTime: this.startTime,
                    endTime: this.endTime,

                })
                    .then(response => {
                        this.saveMedia(response.data, preview);
                    })
                    .catch(e => {
                        this.critError = true;
                    });
            },



            saveMedia(id, preview) {
                if(preview ==='preview'){
                    var url='/template/media/preview?identity='+id;
                } else {
                    var url='/template/media/'+ id;
                }

                var data = new FormData();
                data.append('logo', document.getElementById('logo').files[0]);
                data.append('background', document.getElementById('background').files[0]);

                axios.post(url, data,
                )
                    .then(response => {
                       if(preview !=='preview' ) {
                           this.templateCreated = true;
                           setTimeout(() => {
                               return this.$router.push({name: 'All templates'})
                           }, 1000);
                       }else {
                           window.open('/preview/'+response.data);
                       }

                    })
                    .catch(e => {
                        this.critError = true;

                    });
            },
            hideModal() {
                this.$refs.myModalRef.hide()
            },


        }
    }

</script>

<style scoped>
    .hotels {
        border-radius: 10px;
        float: left;
        width: 100%;
    }

    .hotel-logo {
        width: 200px;
        position: absolute;
        top: 30px;
        right: 10px;
    }


    .form-control {
        margin-left: -1px;
    }

    .color-modal {
        padding-top: 20px;
        padding-bottom: 20px;
        margin-left: -5px;
    }

    .demo-div {
        width: 100px;
        height: 100px
    }

    .fix-margin {
        width: 20%;
        float: left;
        margin: 10px;
    }

    .slider {
        -webkit-appearance: none;
        width: 100%;
        height: 25px;
        background: #d3d3d3;
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

</style>