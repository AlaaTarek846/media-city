import termsCondition from "../../views/admin/termsCondition/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'termsCondition',
        component:  {
            template:'<router-view />',
        },
        children:[
            {
                path: '',
                name: 'termsCondition',
                component: termsCondition,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('terms conditions read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];

