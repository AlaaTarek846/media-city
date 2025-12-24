import newsletter from "../../views/admin/newsletter/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'newsletter',
        
        children:[
            {
                path: '',
                name: 'newsletter',
                component: newsletter,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('newsletter read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
