import shippingInformation from "../../views/admin/shippingInformation/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'shippingInformation',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'shippingInformation',
                component: shippingInformation,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('shipping information read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
