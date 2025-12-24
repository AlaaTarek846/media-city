import product from "../../views/admin/product/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'product',

        children:[
            {
                path: '',
                name: 'product',
                component: product,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('product read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
