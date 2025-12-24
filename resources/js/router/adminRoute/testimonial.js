import testimonial from "../../views/admin/testimonial/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'testimonial',
        
        children:[
            {
                path: '',
                name: 'testimonial',
                component: testimonial,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('testimonial read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
