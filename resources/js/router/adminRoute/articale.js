import article from "../../views/admin/articles/index.vue";
import articleCategory from "../../views/admin/articleCategory/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'article',
        children:[
            {
                path: '',
                name: 'article',
                component: article,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('article read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
    {
        path: 'article-category',
        children:[
            {
                path: '',
                name: 'articleCategory',
                component: articleCategory,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('articleCategory read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
