import returnPolicy from "../../views/admin/returnPolicy/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'returnPolicy',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'returnPolicy',
                component: returnPolicy,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('return policy read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
