import Language from "../../views/admin/language/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'language',
        
        children:[
            {
                path: '',
                name: 'language',
                component: Language,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('language read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
