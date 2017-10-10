export const auth = {
    data() {
        return {
            mac: this.$route.query.clientmac,
            ip: (document.head.querySelector('meta[name="ip"]')).content
        }
    },

    methods: {
        goToMikrotikAuth() {
            //console.log('http://'+this.ip + ':64873/login?username=' + this.mac + '&password=' + this.mac)
             window.location.href ='http://'+this.ip + ':64873/login?username=' + this.mac + '&password=' + this.mac;
        }
    }
}

