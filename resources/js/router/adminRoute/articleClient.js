import articleClient from "../../views/admin/articleClient/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'articleClient',

        children:[
            {
                path: '',
                name: 'articleClient',
                component: articleClient,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('articleClient read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
