import news from "../../views/admin/news/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'news',
        
        children:[
            {
                path: '',
                name: 'news',
                component: news,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('news read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
