import vision from "../../views/admin/vision/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'vision',
        
        children:[
            {
                path: '',
                name: 'vision',
                component: vision,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('vision read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
