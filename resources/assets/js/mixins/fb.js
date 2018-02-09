export const fb = {
    data() {
        return {}
    },

    created() {
        window.fbAsyncInit = function () {
            FB.init({
                appId: '1519471891398547',
                autoLogAppEvents: true,
                xfbml: true,
                version: 'v2.12'
            });
            FB.AppEvents.logPageView();
        };
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

    },
}