import team from "../../views/admin/team/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'team',
        children:[
            {
                path: '',
                name: 'team',
                component: team,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('team read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
