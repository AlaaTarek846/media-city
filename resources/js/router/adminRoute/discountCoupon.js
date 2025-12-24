import discountCoupon from "../../views/admin/discountCoupon/index.vue";
import store from "../../store/admin";

export default [
    {
        path: 'discountCoupon',

        children:[
            {
                path: '',
                name: 'discountCoupon',
                component: discountCoupon,
                beforeEnter: (to, from,next) => {
                    let permission = store.state.authAdmin.permission;

                    if(permission.includes('discount coupon read')){
                        return next();
                    }else{
                        return next({name:'Page404'});
                    }
                }
            },
        ]
    },
];
