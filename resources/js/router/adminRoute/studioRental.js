import studioRental from "../../views/admin/studioRental/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'studio-rentals',

        children:[
            {
                path: '',
                name: 'studioRental',
                component: studioRental,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('studioRental read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
