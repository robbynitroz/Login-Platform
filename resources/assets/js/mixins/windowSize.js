export const windowSize = {

    data() {
        return {
            windowWidth: 0,
        }
    },

    mounted() {
        this.$nextTick(function () {
            window.addEventListener('resize', this.getWindowWidth);
            window.addEventListener('resize', this.getWindowHeight);
            //Init
            this.getWindowWidth()
        })
    },

    beforeDestroy() {
        window.removeEventListener('resize', this.getWindowWidth);
        window.removeEventListener('resize', this.getWindowHeight);
    },

    methods: {

        getWindowWidth(event) {
            this.windowWidth = document.documentElement.clientWidth;
        },

    }

}