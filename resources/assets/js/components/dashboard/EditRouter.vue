<template>
    <div class="wrapper">

        <div v-if="fetchComplite" class="animated fadeIn">

            <div v-if="!isEmpty" class="row">

                <div class="col-md-12">
                    <form enctype="multipart/form-data" @submit.prevent="confirmSave(hotel.id)">
                        <b-card>
                            <div slot="header">
                                <strong>{{ hotel.name }}</strong>
                            </div>


                            <!--Hotel name-->
                            <b-form-fieldset label="Hotel name" description="Type hotel name or change it || Required ">
                                <b-form-fieldset>
                                    <b-input-group left="<i class='fa fa-university'></i>">
                                        <b-form-input type="text" v-model="hotel.name"
                                                      required
                                                      placeholder="Hotel name"></b-form-input>
                                    </b-input-group>
                                </b-form-fieldset>
                            </b-form-fieldset>

                            <!--Hotel url-->
                            <b-form-fieldset label="URL" description="Type hotel URL or change it || Required">
                                <b-form-fieldset>
                                    <b-input-group left="<i class='fa fa-globe'></i>">
                                        <b-form-input type="text" v-model="hotel.main_url"
                                                      required
                                                      placeholder="Hotel URL"></b-form-input>
                                    </b-input-group>
                                </b-form-fieldset>
                            </b-form-fieldset>

                            <!--facebook url-->
                            <b-form-fieldset label="Facebook page URL"
                                             description="Type hotel FB URL or change it || Optional">
                                <b-form-fieldset>
                                    <b-input-group>
                                        <b-form-input type="text" v-model="hotel.facebook_url"
                                                      placeholder="Facebook URL"></b-form-input>
                                    </b-input-group>
                                </b-form-fieldset>
                            </b-form-fieldset>


                            <!--Timeout-->
                            <b-form-fieldset label="Mikrotik timeout for this hotel"
                                             description="Example: 7d (1d default) || Required">
                                <b-form-fieldset>
                                    <b-input-group left="<i class='fa fa-clock-o'></i>">
                                        <b-form-input type="text" v-model="hotel.session_timeout"
                                                      required
                                                      placeholder="TimeoutL"></b-form-input>
                                    </b-input-group>
                                </b-form-fieldset>
                            </b-form-fieldset>


                            <!--hotel timezone-->
                            <b-form-fieldset label="Hotel Timezone"
                                             description="Select hotel timezone">
                                <b-form-select
                                        :plain="true"
                                        :options="timezones"
                                        v-model="timezone"
                                        left="<i class='fa fa-facebook-square'></i> ">
                                </b-form-select>
                            </b-form-fieldset>


                            <!--Hotel logo-->
                            <b-form-fieldset
                                    label="Logo input"
                                    description="Upload Hotel logo || optional"
                            >
                                <b-form-file
                                        id="logo"
                                        label="Logo input"
                                        @change="onFileChange"
                                ></b-form-file>
                            </b-form-fieldset>
                            <b-button
                                    type="button"
                                    @click="uploadImage(hotel.id)"
                                    v-if="uploadButton"
                                    variant="success"><i
                                    class="fa fa-upload"></i>
                                Upload image
                            </b-button>

                            <b-alert v-model="logoUploaded" variant="success" dismissible>
                                Logo successfully updated
                            </b-alert>
                            <div slot="footer">
                                <b-button
                                        type="submit"
                                        variant="primary"><i
                                        class="fa fa-floppy-o"></i>
                                    Save
                                </b-button>
                                <b-button :to="{name:'Hotels'}" variant="secondary"><i class="fa fa-times"></i>
                                    Cancel
                                </b-button>
                                <b-button @click="confirmDelete(hotel.id, hotel.name, 'delete')" variant="danger">
                                    <i class="fa fa-ban"></i> Delete
                                </b-button>

                            </div>
                        </b-card>
                    </form>


                </div>


            </div><!--/.col-->


            <!--Ends here-->


            <b-alert v-model="isEmpty" variant="danger">
                Wrong way or hotel doesn't exist!
                <router-link :to="{name:'Hotels'}">Go back </router-link>
            </b-alert>
        </div><!--/.col-->
        <b-modal centered title="Warning" class="modal-danger" v-model="dangerModal" @ok="deleteHotel(delHotel.id)">
            You are going to delete {{ delHotel.name }}.  Press OK if you are sure
        </b-modal>

        <b-modal centered title="Critical error" class="modal-danger" v-model="critError" hide-footer>
            Please contact your webmaster or support
        </b-modal>
        <b-modal centered ref="myModalRef" size="sm" hide-footer title="Information">
            <div class="d-block text-center">
                <h3>{{ delHotel.name }}  successfully deleted </h3>
            </div>
            <b-btn class="mt-3" variant="success" block @click="hideModal">OK</b-btn>
        </b-modal>

        <b-modal centered v-model="hotelUpdated" class="modal-success" size="sm" hide-footer title="Success">
            <div class="d-block text-center">
                <h3>{{ hotel.name }}  successfully updated </h3>
            </div>
        </b-modal>

    </div>


</template>

<script>


    export default {
        name: 'Hotel',
        components: {},
        data: function () {
            return {

                fetchComplite: false,
                hotel: {
                    id: '',
                    name: '',
                    main_url: '',
                    facebook_url: '',
                    session_timeout: '1d',
                    selectedtimeZone: '',
                    logo: ''

                },
                critError: false,
                hotelUpdated: false,
                logoUploaded: false,
                logo: '',
                isEmpty: true,
                dangerModal: false,
                successDel: true,
                uploadButton: false,
                delHotel: {
                    id: '',
                    name: '',
                    action: ''
                },
                timezones: {
                    "0": "Africa\/Abidjan",
                    "1": "Africa\/Accra",
                    "2": "Africa\/Addis_Ababa",
                    "3": "Africa\/Algiers",
                    "4": "Africa\/Asmara",
                    "5": "Africa\/Bamako",
                    "6": "Africa\/Bangui",
                    "7": "Africa\/Banjul",
                    "8": "Africa\/Bissau",
                    "9": "Africa\/Blantyre",
                    "10": "Africa\/Brazzaville",
                    "11": "Africa\/Bujumbura",
                    "12": "Africa\/Cairo",
                    "13": "Africa\/Casablanca",
                    "14": "Africa\/Ceuta",
                    "15": "Africa\/Conakry",
                    "16": "Africa\/Dakar",
                    "17": "Africa\/Dar_es_Salaam",
                    "18": "Africa\/Djibouti",
                    "19": "Africa\/Douala",
                    "20": "Africa\/El_Aaiun",
                    "21": "Africa\/Freetown",
                    "22": "Africa\/Gaborone",
                    "23": "Africa\/Harare",
                    "24": "Africa\/Johannesburg",
                    "25": "Africa\/Juba",
                    "26": "Africa\/Kampala",
                    "27": "Africa\/Khartoum",
                    "28": "Africa\/Kigali",
                    "29": "Africa\/Kinshasa",
                    "30": "Africa\/Lagos",
                    "31": "Africa\/Libreville",
                    "32": "Africa\/Lome",
                    "33": "Africa\/Luanda",
                    "34": "Africa\/Lubumbashi",
                    "35": "Africa\/Lusaka",
                    "36": "Africa\/Malabo",
                    "37": "Africa\/Maputo",
                    "38": "Africa\/Maseru",
                    "39": "Africa\/Mbabane",
                    "40": "Africa\/Mogadishu",
                    "41": "Africa\/Monrovia",
                    "42": "Africa\/Nairobi",
                    "43": "Africa\/Ndjamena",
                    "44": "Africa\/Niamey",
                    "45": "Africa\/Nouakchott",
                    "46": "Africa\/Ouagadougou",
                    "47": "Africa\/Porto-Novo",
                    "48": "Africa\/Sao_Tome",
                    "49": "Africa\/Tripoli",
                    "50": "Africa\/Tunis",
                    "51": "Africa\/Windhoek",
                    "52": "America\/Adak",
                    "53": "America\/Anchorage",
                    "54": "America\/Anguilla",
                    "55": "America\/Antigua",
                    "56": "America\/Araguaina",
                    "57": "America\/Argentina\/Buenos_Aires",
                    "58": "America\/Argentina\/Catamarca",
                    "59": "America\/Argentina\/Cordoba",
                    "60": "America\/Argentina\/Jujuy",
                    "61": "America\/Argentina\/La_Rioja",
                    "62": "America\/Argentina\/Mendoza",
                    "63": "America\/Argentina\/Rio_Gallegos",
                    "64": "America\/Argentina\/Salta",
                    "65": "America\/Argentina\/San_Juan",
                    "66": "America\/Argentina\/San_Luis",
                    "67": "America\/Argentina\/Tucuman",
                    "68": "America\/Argentina\/Ushuaia",
                    "69": "America\/Aruba",
                    "70": "America\/Asuncion",
                    "71": "America\/Atikokan",
                    "72": "America\/Bahia",
                    "73": "America\/Bahia_Banderas",
                    "74": "America\/Barbados",
                    "75": "America\/Belem",
                    "76": "America\/Belize",
                    "77": "America\/Blanc-Sablon",
                    "78": "America\/Boa_Vista",
                    "79": "America\/Bogota",
                    "80": "America\/Boise",
                    "81": "America\/Cambridge_Bay",
                    "82": "America\/Campo_Grande",
                    "83": "America\/Cancun",
                    "84": "America\/Caracas",
                    "85": "America\/Cayenne",
                    "86": "America\/Cayman",
                    "87": "America\/Chicago",
                    "88": "America\/Chihuahua",
                    "89": "America\/Costa_Rica",
                    "90": "America\/Creston",
                    "91": "America\/Cuiaba",
                    "92": "America\/Curacao",
                    "93": "America\/Danmarkshavn",
                    "94": "America\/Dawson",
                    "95": "America\/Dawson_Creek",
                    "96": "America\/Denver",
                    "97": "America\/Detroit",
                    "98": "America\/Dominica",
                    "99": "America\/Edmonton",
                    "100": "America\/Eirunepe",
                    "101": "America\/El_Salvador",
                    "102": "America\/Fort_Nelson",
                    "103": "America\/Fortaleza",
                    "104": "America\/Glace_Bay",
                    "105": "America\/Godthab",
                    "106": "America\/Goose_Bay",
                    "107": "America\/Grand_Turk",
                    "108": "America\/Grenada",
                    "109": "America\/Guadeloupe",
                    "110": "America\/Guatemala",
                    "111": "America\/Guayaquil",
                    "112": "America\/Guyana",
                    "113": "America\/Halifax",
                    "114": "America\/Havana",
                    "115": "America\/Hermosillo",
                    "116": "America\/Indiana\/Indianapolis",
                    "117": "America\/Indiana\/Knox",
                    "118": "America\/Indiana\/Marengo",
                    "119": "America\/Indiana\/Petersburg",
                    "120": "America\/Indiana\/Tell_City",
                    "121": "America\/Indiana\/Vevay",
                    "122": "America\/Indiana\/Vincennes",
                    "123": "America\/Indiana\/Winamac",
                    "124": "America\/Inuvik",
                    "125": "America\/Iqaluit",
                    "126": "America\/Jamaica",
                    "127": "America\/Juneau",
                    "128": "America\/Kentucky\/Louisville",
                    "129": "America\/Kentucky\/Monticello",
                    "130": "America\/Kralendijk",
                    "131": "America\/La_Paz",
                    "132": "America\/Lima",
                    "133": "America\/Los_Angeles",
                    "134": "America\/Lower_Princes",
                    "135": "America\/Maceio",
                    "136": "America\/Managua",
                    "137": "America\/Manaus",
                    "138": "America\/Marigot",
                    "139": "America\/Martinique",
                    "140": "America\/Matamoros",
                    "141": "America\/Mazatlan",
                    "142": "America\/Menominee",
                    "143": "America\/Merida",
                    "144": "America\/Metlakatla",
                    "145": "America\/Mexico_City",
                    "146": "America\/Miquelon",
                    "147": "America\/Moncton",
                    "148": "America\/Monterrey",
                    "149": "America\/Montevideo",
                    "150": "America\/Montserrat",
                    "151": "America\/Nassau",
                    "152": "America\/New_York",
                    "153": "America\/Nipigon",
                    "154": "America\/Nome",
                    "155": "America\/Noronha",
                    "156": "America\/North_Dakota\/Beulah",
                    "157": "America\/North_Dakota\/Center",
                    "158": "America\/North_Dakota\/New_Salem",
                    "159": "America\/Ojinaga",
                    "160": "America\/Panama",
                    "161": "America\/Pangnirtung",
                    "162": "America\/Paramaribo",
                    "163": "America\/Phoenix",
                    "164": "America\/Port-au-Prince",
                    "165": "America\/Port_of_Spain",
                    "166": "America\/Porto_Velho",
                    "167": "America\/Puerto_Rico",
                    "168": "America\/Punta_Arenas",
                    "169": "America\/Rainy_River",
                    "170": "America\/Rankin_Inlet",
                    "171": "America\/Recife",
                    "172": "America\/Regina",
                    "173": "America\/Resolute",
                    "174": "America\/Rio_Branco",
                    "175": "America\/Santarem",
                    "176": "America\/Santiago",
                    "177": "America\/Santo_Domingo",
                    "178": "America\/Sao_Paulo",
                    "179": "America\/Scoresbysund",
                    "180": "America\/Sitka",
                    "181": "America\/St_Barthelemy",
                    "182": "America\/St_Johns",
                    "183": "America\/St_Kitts",
                    "184": "America\/St_Lucia",
                    "185": "America\/St_Thomas",
                    "186": "America\/St_Vincent",
                    "187": "America\/Swift_Current",
                    "188": "America\/Tegucigalpa",
                    "189": "America\/Thule",
                    "190": "America\/Thunder_Bay",
                    "191": "America\/Tijuana",
                    "192": "America\/Toronto",
                    "193": "America\/Tortola",
                    "194": "America\/Vancouver",
                    "195": "America\/Whitehorse",
                    "196": "America\/Winnipeg",
                    "197": "America\/Yakutat",
                    "198": "America\/Yellowknife",
                    "199": "Antarctica\/Casey",
                    "200": "Antarctica\/Davis",
                    "201": "Antarctica\/DumontDUrville",
                    "202": "Antarctica\/Macquarie",
                    "203": "Antarctica\/Mawson",
                    "204": "Antarctica\/McMurdo",
                    "205": "Antarctica\/Palmer",
                    "206": "Antarctica\/Rothera",
                    "207": "Antarctica\/Syowa",
                    "208": "Antarctica\/Troll",
                    "209": "Antarctica\/Vostok",
                    "210": "Arctic\/Longyearbyen",
                    "211": "Asia\/Aden",
                    "212": "Asia\/Almaty",
                    "213": "Asia\/Amman",
                    "214": "Asia\/Anadyr",
                    "215": "Asia\/Aqtau",
                    "216": "Asia\/Aqtobe",
                    "217": "Asia\/Ashgabat",
                    "218": "Asia\/Atyrau",
                    "219": "Asia\/Baghdad",
                    "220": "Asia\/Bahrain",
                    "221": "Asia\/Baku",
                    "222": "Asia\/Bangkok",
                    "223": "Asia\/Barnaul",
                    "224": "Asia\/Beirut",
                    "225": "Asia\/Bishkek",
                    "226": "Asia\/Brunei",
                    "227": "Asia\/Chita",
                    "228": "Asia\/Choibalsan",
                    "229": "Asia\/Colombo",
                    "230": "Asia\/Damascus",
                    "231": "Asia\/Dhaka",
                    "232": "Asia\/Dili",
                    "233": "Asia\/Dubai",
                    "234": "Asia\/Dushanbe",
                    "235": "Asia\/Famagusta",
                    "236": "Asia\/Gaza",
                    "237": "Asia\/Hebron",
                    "238": "Asia\/Ho_Chi_Minh",
                    "239": "Asia\/Hong_Kong",
                    "240": "Asia\/Hovd",
                    "241": "Asia\/Irkutsk",
                    "242": "Asia\/Jakarta",
                    "243": "Asia\/Jayapura",
                    "244": "Asia\/Jerusalem",
                    "245": "Asia\/Kabul",
                    "246": "Asia\/Kamchatka",
                    "247": "Asia\/Karachi",
                    "248": "Asia\/Kathmandu",
                    "249": "Asia\/Khandyga",
                    "250": "Asia\/Kolkata",
                    "251": "Asia\/Krasnoyarsk",
                    "252": "Asia\/Kuala_Lumpur",
                    "253": "Asia\/Kuching",
                    "254": "Asia\/Kuwait",
                    "255": "Asia\/Macau",
                    "256": "Asia\/Magadan",
                    "257": "Asia\/Makassar",
                    "258": "Asia\/Manila",
                    "259": "Asia\/Muscat",
                    "260": "Asia\/Nicosia",
                    "261": "Asia\/Novokuznetsk",
                    "262": "Asia\/Novosibirsk",
                    "263": "Asia\/Omsk",
                    "264": "Asia\/Oral",
                    "265": "Asia\/Phnom_Penh",
                    "266": "Asia\/Pontianak",
                    "267": "Asia\/Pyongyang",
                    "268": "Asia\/Qatar",
                    "269": "Asia\/Qyzylorda",
                    "270": "Asia\/Riyadh",
                    "271": "Asia\/Sakhalin",
                    "272": "Asia\/Samarkand",
                    "273": "Asia\/Seoul",
                    "274": "Asia\/Shanghai",
                    "275": "Asia\/Singapore",
                    "276": "Asia\/Srednekolymsk",
                    "277": "Asia\/Taipei",
                    "278": "Asia\/Tashkent",
                    "279": "Asia\/Tbilisi",
                    "280": "Asia\/Tehran",
                    "281": "Asia\/Thimphu",
                    "282": "Asia\/Tokyo",
                    "283": "Asia\/Tomsk",
                    "284": "Asia\/Ulaanbaatar",
                    "285": "Asia\/Urumqi",
                    "286": "Asia\/Ust-Nera",
                    "287": "Asia\/Vientiane",
                    "288": "Asia\/Vladivostok",
                    "289": "Asia\/Yakutsk",
                    "290": "Asia\/Yangon",
                    "291": "Asia\/Yekaterinburg",
                    "292": "Asia\/Yerevan",
                    "293": "Atlantic\/Azores",
                    "294": "Atlantic\/Bermuda",
                    "295": "Atlantic\/Canary",
                    "296": "Atlantic\/Cape_Verde",
                    "297": "Atlantic\/Faroe",
                    "298": "Atlantic\/Madeira",
                    "299": "Atlantic\/Reykjavik",
                    "300": "Atlantic\/South_Georgia",
                    "301": "Atlantic\/St_Helena",
                    "302": "Atlantic\/Stanley",
                    "303": "Australia\/Adelaide",
                    "304": "Australia\/Brisbane",
                    "305": "Australia\/Broken_Hill",
                    "306": "Australia\/Currie",
                    "307": "Australia\/Darwin",
                    "308": "Australia\/Eucla",
                    "309": "Australia\/Hobart",
                    "310": "Australia\/Lindeman",
                    "311": "Australia\/Lord_Howe",
                    "312": "Australia\/Melbourne",
                    "313": "Australia\/Perth",
                    "314": "Australia\/Sydney",
                    "315": "Europe\/Amsterdam",
                    "316": "Europe\/Andorra",
                    "317": "Europe\/Astrakhan",
                    "318": "Europe\/Athens",
                    "319": "Europe\/Belgrade",
                    "320": "Europe\/Berlin",
                    "321": "Europe\/Bratislava",
                    "322": "Europe\/Brussels",
                    "323": "Europe\/Bucharest",
                    "324": "Europe\/Budapest",
                    "325": "Europe\/Busingen",
                    "326": "Europe\/Chisinau",
                    "327": "Europe\/Copenhagen",
                    "328": "Europe\/Dublin",
                    "329": "Europe\/Gibraltar",
                    "330": "Europe\/Guernsey",
                    "331": "Europe\/Helsinki",
                    "332": "Europe\/Isle_of_Man",
                    "333": "Europe\/Istanbul",
                    "334": "Europe\/Jersey",
                    "335": "Europe\/Kaliningrad",
                    "336": "Europe\/Kiev",
                    "337": "Europe\/Kirov",
                    "338": "Europe\/Lisbon",
                    "339": "Europe\/Ljubljana",
                    "340": "Europe\/London",
                    "341": "Europe\/Luxembourg",
                    "342": "Europe\/Madrid",
                    "343": "Europe\/Malta",
                    "344": "Europe\/Mariehamn",
                    "345": "Europe\/Minsk",
                    "346": "Europe\/Monaco",
                    "347": "Europe\/Moscow",
                    "348": "Europe\/Oslo",
                    "349": "Europe\/Paris",
                    "350": "Europe\/Podgorica",
                    "351": "Europe\/Prague",
                    "352": "Europe\/Riga",
                    "353": "Europe\/Rome",
                    "354": "Europe\/Samara",
                    "355": "Europe\/San_Marino",
                    "356": "Europe\/Sarajevo",
                    "357": "Europe\/Saratov",
                    "358": "Europe\/Simferopol",
                    "359": "Europe\/Skopje",
                    "360": "Europe\/Sofia",
                    "361": "Europe\/Stockholm",
                    "362": "Europe\/Tallinn",
                    "363": "Europe\/Tirane",
                    "364": "Europe\/Ulyanovsk",
                    "365": "Europe\/Uzhgorod",
                    "366": "Europe\/Vaduz",
                    "367": "Europe\/Vatican",
                    "368": "Europe\/Vienna",
                    "369": "Europe\/Vilnius",
                    "370": "Europe\/Volgograd",
                    "371": "Europe\/Warsaw",
                    "372": "Europe\/Zagreb",
                    "373": "Europe\/Zaporozhye",
                    "374": "Europe\/Zurich",
                    "375": "Indian\/Antananarivo",
                    "376": "Indian\/Chagos",
                    "377": "Indian\/Christmas",
                    "378": "Indian\/Cocos",
                    "379": "Indian\/Comoro",
                    "380": "Indian\/Kerguelen",
                    "381": "Indian\/Mahe",
                    "382": "Indian\/Maldives",
                    "383": "Indian\/Mauritius",
                    "384": "Indian\/Mayotte",
                    "385": "Indian\/Reunion",
                    "386": "Pacific\/Apia",
                    "387": "Pacific\/Auckland",
                    "388": "Pacific\/Bougainville",
                    "389": "Pacific\/Chatham",
                    "390": "Pacific\/Chuuk",
                    "391": "Pacific\/Easter",
                    "392": "Pacific\/Efate",
                    "393": "Pacific\/Enderbury",
                    "394": "Pacific\/Fakaofo",
                    "395": "Pacific\/Fiji",
                    "396": "Pacific\/Funafuti",
                    "397": "Pacific\/Galapagos",
                    "398": "Pacific\/Gambier",
                    "399": "Pacific\/Guadalcanal",
                    "400": "Pacific\/Guam",
                    "401": "Pacific\/Honolulu",
                    "402": "Pacific\/Kiritimati",
                    "403": "Pacific\/Kosrae",
                    "404": "Pacific\/Kwajalein",
                    "405": "Pacific\/Majuro",
                    "406": "Pacific\/Marquesas",
                    "407": "Pacific\/Midway",
                    "408": "Pacific\/Nauru",
                    "409": "Pacific\/Niue",
                    "410": "Pacific\/Norfolk",
                    "411": "Pacific\/Noumea",
                    "412": "Pacific\/Pago_Pago",
                    "413": "Pacific\/Palau",
                    "414": "Pacific\/Pitcairn",
                    "415": "Pacific\/Pohnpei",
                    "416": "Pacific\/Port_Moresby",
                    "417": "Pacific\/Rarotonga",
                    "418": "Pacific\/Saipan",
                    "419": "Pacific\/Tahiti",
                    "420": "Pacific\/Tarawa",
                    "421": "Pacific\/Tongatapu",
                    "422": "Pacific\/Wake",
                    "423": "Pacific\/Wallis",
                    "424": "UTC"
                },


            }
        },

        mounted() {
            let config = {
                onUploadProgress: progressEvent => {

                }
            };
            axios.get('/hotel/' + this.$route.params.hotelID,
                config)
                .then(response => {
                    //this.loading = '';
                    //this.fetchComplete = true;

                    if (response.data.name) {
                        this.isEmpty = false;
                        this.hotel.id = response.data.id;
                        this.hotel.name = response.data.name;
                        this.hotel.facebook_url = response.data.facebook_url;
                        this.hotel.logo = response.data.logo;
                        this.hotel.main_url = response.data.main_url;
                        this.hotel.timezone = response.data.timezone;
                        this.session_timeout = response.data.session_timeout


                    } else {
                        console.log("sellers is not empty !");
                    }
                    this.fetchComplite = true;

                })
                .catch(e => {
                    this.critError = true;

                });

        },

        computed: {

            timezone: {
                // getter
                get: function () {
                    for (var key in this.timezones) {
                        if (this.timezones[key] == this.hotel.timezone) {
                            return key
                        }
                    }
                },
                // setter
                set: function (timeZone) {
                    this.hotel.timezone = timeZone;
                }
            },

            timezoneChange() {
                this.hotel.selectedtimeZone = this.timezones[this.hotel.timezone]
            }


        },

        methods: {


            onFileChange(e) {
                this.uploadButton = true
            },

            confirmSave(id) {

                axios.put('/hotel/' + id, {
                    hotel: this.hotel,
                    timezone: this.timezones[this.hotel.timezone],
                })
                    .then(response => {
                        this.hotelUpdated = true;
                        setTimeout(() => {
                            return this.$router.push({name: 'Hotels'})
                        }, 1000);
                    })
                    .catch(e => {
                        this.critError = true;
                    });
            },

            uploadImage(id) {

                var data = new FormData();
                data.append('logo', document.getElementById('logo').files[0]);

                axios.post('/hotel/files/' + id, data,
                )
                    .then(response => {
                        this.logoUploaded = true

                    })
                    .catch(e => {
                        this.critError = true;

                    });

            },

            hideModal() {
                this.$refs.myModalRef.hide()
            },

            confirmDelete(id, name, action) {
                this.delHotel.id = id;
                this.delHotel.name = name;
                this.deleteHotel.action = action
                this.dangerModal = true

            },

            deleteHotel(id) {
                axios.delete('/hotel/' + id)
                    .then(response => {
                        return this.$router.push({name: 'Hotels'})
                    })
                    .catch(e => {
                        this.critError = true;
                    });
            },

            afterDelete() {
                this.$refs.myModalRef.show();
                this.hotels = response.data;
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

    .form-control {
        margin-left: -1px;
    }
</style>