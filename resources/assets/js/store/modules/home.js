const state = JSON.parse((document.head.querySelector('script[id="mainData"]')).innerHTML.replace(/^\s+|\s+$/g, ''));



const getters = {
    video: state => {
        return state.video;
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


};

const actions = {

    updateActiveComponent: ({commit}, payload) => {
        commit('changeActiveComponent', payload);
    },

};

export default {
    getters,
    state,
    mutations,
    actions
}