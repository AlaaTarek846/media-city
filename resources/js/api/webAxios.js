import axios from "axios";
import Cookies from "js-cookie";
// import store from "../store/admin.js";
// import adminRoute from "../router/adminRoute.js";


const webApi = axios.create({
    baseURL: `${window.location.origin}/api/`
});

let lang  = $('meta[name="language"]').attr('content')
webApi.interceptors.request.use(
    function (config) {
        config.headers['lang'] = lang;
        config.headers['Accept-Language'] = lang;
        config.headers['Authorization'] = "Bearer " + (Cookies.get("token") || '');
        return config;
    },
    function (error) {
        return Promise.reject(error);
    }
);
webApi.defaults.headers.common['Accept'] = 'application/json';
webApi.defaults.headers.common['lang'] = lang;
webApi.defaults.headers.common['Accept-Language'] = lang;

webApi.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    if (401 === error.response.status) {
        // // handle error: inform user, go to login, etc
        // adminRoute.push({name: 'login'});
        // store.commit('authAdmin/logoutToken');
    } else {
        return Promise.reject(error);
    }
});
// end axios
export default webApi;
