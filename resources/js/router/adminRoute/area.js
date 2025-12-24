import area from "../../views/admin/area/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'area',
        
        children:[
            {
                path: '',
                name: 'area',
                component: area,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('area read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
