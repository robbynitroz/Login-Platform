export const windowSize = {

    data() {
        return {
            windowWidth: 0,
        }
    },

    mounted() {
        this.$nextTick(function () {
            window.addEventListener('resize', this.getWindowWidth);
            //Init
            this.getWindowWidth()
        })
    },

    beforeDestroy() {
        window.removeEventListener('resize', this.getWindowWidth);
    },

    methods: {

        getWindowWidth(event) {
            this.windowWidth = document.documentElement.clientWidth;
        },

    }

}