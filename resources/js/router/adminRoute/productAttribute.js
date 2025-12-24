import productAttribute from "../../views/admin/productAttribute/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'productAttribute',

        children:[
            {
                path: '',
                name: 'productAttribute',
                component: productAttribute,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('product attribute read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
