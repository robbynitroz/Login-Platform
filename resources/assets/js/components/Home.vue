<template>
    <div class="container-fluid">
        <video v-if="videoShowOrHide" autoplay preload loop muted :poster="video.cover" id="background">
            <source :src="video.src" :type="video.type">
        </video>
        <transition name="entry" appear mode="out-in">
            <component :is="activeComponent"></component>
        </transition>

    </div>

</template>

<script>
    import {mapGetters} from 'vuex';
    import {windowSize} from '../mixins/windowSize';
    import appLogin from './Login.vue';
    import appPolicy from './Policy.vue';
    import appEmail from './Email.vue';



    export default {
        name: 'app',
        data() {
            return {

            }
        },

        components: {
            appLogin,
            appPolicy,
            appEmail
        },

        mixins: [windowSize],


        computed: {
            // whenever the document is resized, re-set the 'fullHeight' variable

            videoShowOrHide() {


                if (this.windowWidth > 576) {
                    return true
                } else {
                    return false
                }


            },

            ...mapGetters([
                'activeComponent',
                'video',
            ]),



        },

    }
</script>

<style scoped>

    #background {
        position: fixed;
        top: 50%;
        left: 50%;
        min-width: 100%;
        min-height: 100%;
        width: auto;
        height: auto;
        z-index: -100;
        -webkit-transform: translateX(-50%) translateY(-50%);
        transform: translateX(-50%) translateY(-50%);
        background-size: cover;
    }


    .vertical-center {
        min-height: 100%; /* Fallback for vh unit */
        min-height: 100vh;
        /* You might also want to use
                               'height' property instead.

                               Note that for percentage values of
                               'height' or 'min-height' properties,
                               the 'height' of the parent element
                               should be specified explicitly.

                               In this case the parent of '.vertical-center'
                               is the <body> element */

        /* Make it a flex container */
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;

        /* Align the bootstrap's container vertically */
        -webkit-box-align: center;
        -webkit-align-items: center;
        -moz-box-align: center;
        -ms-flex-align: center;
        align-items: center;

        /* In legacy web browsers such as Firefox 9
           we need to specify the width of the flex container */
        width: 100%;

        /* Also 'margin: 0 auto' doesn't have any effect on flex items in such web browsers
           hence the bootstrap's container won't be aligned to the center anymore.

           Therefore, we should use the following declarations to get it centered again */
        -webkit-box-pack: center;
        -moz-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
    }

    .entry-enter {

        opacity: 0;
    }

    .entry-enter-active {
        transition: opacity 0.6s;

    }

    .entry-leave {
        opacity: 1;

    }

    .entry-leave-active {
        transition: opacity 0.6s;
        opacity: 0;

    }

    @media screen and (max-width: 576px) {
        .container-fluid {
            padding: 0;
        }

    }

</style>