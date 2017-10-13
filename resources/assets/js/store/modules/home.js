const state = {

    activeComponent: 'app-email',
    defaultComponent: 'app-email',
    video: {
        src: 'storage/images/videoplayback.mp4',
        type: 'video/mp4',
        cover: '/storage/images/conser.jpg'
    },
};

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
    state,
    getters,
    mutations,
    actions
}