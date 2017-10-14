const state = JSON.parse((document.head.querySelector('script[id="mainData"]')).innerHTML.replace(/^\s+|\s+$/g, ''));

/*
    {

    texts: {
        en: {

            greetingText: "You're one step away from going online",
            buttonText: 'GO ONLINE HERE',
            policyLinkText: 'Terms & conditions',
            policyBackLinkText: '<<< Back ',
            policyText: '<p style="color: white">Here you will find terms and condition text<p/>',
            emailText:'Your email address here'

        }
    },

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
    greeting: {
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
    littleTextColor: {
        color: 'white',
        text: 'connect and proceed to our webapp'
    }
};*/


const getters = {

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

    greeting: state => {
        return state.greeting;
    },

    button: state => {
        return state.button;
    },

    buttonIcon: state => {
        return state.buttonIcon;
    },

    littleTextColor: state => {
        return state.littleTextColor;
    },

    texts: state => {
        return state.texts;
    },

};

export default {
    state,
    getters,
}