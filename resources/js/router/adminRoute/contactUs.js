import contactUs from "../../views/admin/contactUs/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'contactUs',
        
        children:[
            {
                path: '',
                name: 'contactUs',
                component: contactUs,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('contact us read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
