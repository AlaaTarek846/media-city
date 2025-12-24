import frequentlyAskedQuestion from "../../views/admin/frequentlyAskedQuestion/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'frequentlyAskedQuestion',
        
        children:[
            {
                path: '',
                name: 'frequentlyAskedQuestion',
                component: frequentlyAskedQuestion,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('frequently asked question read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
