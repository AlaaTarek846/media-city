import aboutUs from "../../views/admin/aboutUs/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'aboutUs',

        children:[
            {
                path: '',
                name: 'aboutUs',
                component: aboutUs,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('about us read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
