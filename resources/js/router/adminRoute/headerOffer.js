import headerOffer from "../../views/admin/headerOffer/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'header-offers',

        children:[
            {
                path: '',
                name: 'headerOffer',
                component: headerOffer,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('headerOffer read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
