import departments from "../../views/admin/department/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'departments',

        children:[
            {
                path: '',
                name: 'departments',
                component: departments,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('department read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
