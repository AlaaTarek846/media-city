import order from "../../views/admin/order/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'order',

        children:[
            {
                path: '',
                name: 'order',
                component: order,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('order read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
