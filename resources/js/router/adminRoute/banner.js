import Banner from "../../views/admin/banner/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'banner',
       
        children:[
            {
                path: '',
                name: 'banner',
                component: Banner,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('banner read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
