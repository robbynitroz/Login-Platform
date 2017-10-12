import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({

    state: {

        backgroundColor: 'background: rgba(19, 17, 17, 0.72);',
        hotelLogo: 'storage/images/hotel_logo.png',
        policy: {
            text: 'Terms & conditions',
            color: 'grey',
            size: "1" + 'rem',
        },
        greetingsTime: {
            on: true,
            color: 'white',
            size: 2.4 + 'rem'
        },
        greetingText: {
            color: 'white',
            text: "You're one step away from going online",
            size: 2 + 'rem'
        },
        button: {
            colorBackd: '#1e2021',
            colorBackdHover: '#000000',
            text: 'GO ONLINE HERE',
            color: '#d3e0ff',
            colorHover: "#ffffff",
            borderColor: '#d3e0ff',
            borderColorHover: "#ffffff",
            hoverState: false
        },
        buttonIcon: {
            class: 'fa-globe',
            color: '#d3e0ff',
            colorHover: "#ffffff"
        },
        littleText: {
            color: 'white',
            text: 'connect and proceed to our webapp'
        }
    },


    getters: {

        backgroundColor: state => {
            return state.backgroundColor;
        },
        hotelLogo: state => {
            return state.hotelLogo;
        },
        policy: state => {
            return state.policy;
        },

        greetingsTime: state => {
            return state.greetingsTime;
        },

        greetingText: state => {
            return state.greetingText;
        },

        button: state => {
            return state.button;
        },

        buttonIcon: state => {
            return state.buttonIcon;
        },

        littleText: state => {
            return state.littleText;
        },

    }


});