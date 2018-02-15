export const email = {
    methods: {
        swither() {
            this.apiOn = !this.apiOn
        },


        tokenGen(api = false) {
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            var text = '';
            for (var i = 0; i < 35; i++) {
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            }
            if (api === true) {
                this.apiToken = text
            } else {
                this.token = text
            }
        },

        getData() {
            axios.get('/hotels').then(response => {
                    this.preHotels = response.data;
                    this.preHotels.forEach(el => {
                        this.options.push({
                            id: el.id,
                            label: el.name
                        })
                    })
                if(this.$options.name == 'EditEmailSetting'){
                    this.getSecondary()
                }
                }
            ).catch(e => {
                this.errors = true
            })
        },
    },
}