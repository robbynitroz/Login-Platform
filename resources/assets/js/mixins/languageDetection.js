export const languageDetection = {

    data() {
        return {
            defaultLanguage:'en'
        }
    },

    mounted() {
        this.$nextTick(function () {
            let userLang = navigator.language || navigator.userLanguage;
            userLang  = userLang.substring(0, 2);
            this.checkUserLang(userLang);
        })
    },


    methods: {

        checkUserLang(userLang){

            if (typeof this.texts[userLang] !== "undefined") {
                this.defaultLanguage=userLang;
            }
        }

    }

}