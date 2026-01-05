import Slider from "../../views/admin/slider/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'sliders',

        children:[
            {
                path: '',
                name: 'slider',
                component: Slider,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('slider read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
