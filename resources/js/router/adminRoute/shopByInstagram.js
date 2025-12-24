import shopByInstagram from "../../views/admin/shopByInstagram/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'shopByInstagram',

        children:[
            {
                path: '',
                name: 'shopByInstagram',
                component: shopByInstagram,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('shop by instagram read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
