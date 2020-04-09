import Vue from 'vue'
import Router from 'vue-router'
import Account from '../view/account/account.vue'
import store from "../store/webstore";
import _ from 'lodash'

Vue.use(Router);

//there is need auth prop
const routeAuthentication = ({auth}) => {
    return (!_.isNull(auth));
};




const router = new Router({
    routes: [
        {
            /*
            * Account manage routes*/
            path: '/account',
            name: 'AccountManage',
            components: {
                AccountManage: Account
            },
            children: [
                {
                    /*
                    * Route to login current user
                    *  */
                    path: '/login',
                    name: 'LoginUser',
                    component: () => import('../view/account/login.vue')
                },
                {
                    /*
                    * Route to register
                    *  */
                    path: '/register',
                    name: 'RegisterUser',
                    component: () => import('../view/account/register.vue'),
                },
                {
                    /*
                    * Route to update current user
                    *  */
                    path: '/updateuser',
                    name: 'UpdateUser',
                    component: () => import('../view/account/update.vue'),
                    meta: store.getters.isLogged
                },
                {
                    path: '*',
                    redirect: {name: 'LoginUser'}
                }
            ]
        }
    ]
});

router.beforeEach((to, from, next) => {
    if (routeAuthentication(to.meta))
        next();

});


export default router;