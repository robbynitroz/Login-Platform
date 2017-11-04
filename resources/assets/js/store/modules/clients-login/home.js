import {data} from './loginState'

const state = data

const getters = {
    media: state => {
        return state.media;
    },
    activeComponent: state => {
        return state.activeComponent
    },

    defaultComponent: state => {
        return state.defaultComponent
    },

};

const mutations = {
    changeActiveComponent: (state, payload) => {
        state.activeComponent = payload;
    },

    loadData(){

    }

};

const actions = {

    updateActiveComponent: ({commit}, payload) => {
        commit('changeActiveComponent', payload);
    },

};

export default {
    state,
    getters,
    mutations,
    actions
}