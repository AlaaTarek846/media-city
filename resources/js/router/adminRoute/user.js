import user from "../../views/admin/user/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'user',

        children:[
            {
                path: '',
                name: 'user',
                component: user,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('user read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
