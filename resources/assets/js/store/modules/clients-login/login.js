import {data} from './loginState'
const state = data




const getters = {

    backgroundColor: state => {
        return state.backgroundColor;
    },
    hotelLogo: state => {
        return '/storage/images/'+state.hotelLogo;
    },
    policy: state => {
        return state.policy;
    },

    greetingsTime: state => {
        return state.greetingsTime;
    },

    greeting: state => {
        return state.greeting;
    },

    button: state => {
        return state.button;
    },


    littleTextColor: state => {
        return state.littleTextColor;
    },

    texts: state => {
        return state.texts;
    },

    requireEmail: state => {
        return state.requireEmail;
    },

};

export default {
    state,
    getters,
}