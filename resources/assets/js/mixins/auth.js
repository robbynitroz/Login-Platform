export const auth = {
    data() {
        return {
            mac: this.$route.query.clientmac,
            ip: (document.head.querySelector('meta[name="ip"]')).content
        }
    },

    methods: {
        goToMikrotikAuth() {
            window.location.href = 'http://' + this.ip + ':64873/login?username=' + this.mac + '&password=' + this.mac;
        },

        sendEmailToServer(email){
            console.log(email)
        }
    }
}

