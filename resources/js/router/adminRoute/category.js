import category from "../../views/admin/category/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'category',

        children:[
            {
                path: '',
                name: 'category',
                component: category,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('category read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
