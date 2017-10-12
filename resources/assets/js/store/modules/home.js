const state = {

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
}

export default {
    state,
    getters
}