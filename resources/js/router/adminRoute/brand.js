import brand from "../../views/admin/brand/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'brand',
       
        children:[
            {
                path: '',
                name: 'brand',
                component: brand,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('brand read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
