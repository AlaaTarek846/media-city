import contactMessage from "../../views/admin/contactMessage/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'contactMessage',
       
        children:[
            {
                path: '',
                name: 'contactMessage',
                component: contactMessage,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('contact message read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
