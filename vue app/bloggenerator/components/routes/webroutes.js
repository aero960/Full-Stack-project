import Vue from 'vue'
import Router from 'vue-router'
import store from "../store/webstore";
import _ from 'lodash'

Vue.use(Router);

/*
* Routes status
* types
* */
const AuthenticationStatus = {
    BEFORE: 'BEFORE',
    NEED: 'NEED',
    NORMAL: 'NORMAL'
};

const addAuthStatus = (type) => {
    return {auth: AuthenticationStatus[type]}
};

const router = new Router({
    mode: 'history',
    base: 'bloggenerator',
    routes: [
        {        /*
            * Post manage routes*/
            path: '/post',
            name: 'PostManage',
            components: {
                default:   () => import("../view/post/post.vue"),
            },
            children: [
                {
                    path: ':postId',
                    name: 'ActivePost',
                    components:{
                        ActivePost:() => import('../view/post/activepost.vue')
                    }
                },
            ]
        },
        {
            /*
            * Account manage routes*/
            path: '/account',
            name: 'AccountManage',
            component: () => import('../view/account/account.vue'),
            children: [
                {
                    /*
                    * Route to login current user
                    *  */
                    path: '/login',
                    name: 'LoginUser',
                    component: () => import('../view/account/login.vue'),
                    meta: {
                        auth: AuthenticationStatus.BEFORE
                    }
                },
                {
                    /*
                    * Route to register
                    *  */
                    path: '/register',
                    name: 'RegisterUser',
                    component: () => import('../view/account/register.vue'),
                    meta: {
                        auth: AuthenticationStatus.BEFORE
                    }

                },
                {
                    /*
                    * Route to update current user
                    *  */
                    path: '/updateuser',
                    name: 'UpdateUser',
                    component: () => import('../view/account/update.vue'),
                    meta: {
                        auth: AuthenticationStatus.NEED
                    }
                },
                {
                    /*
                    * Route to update current user
                    *  */
                    path: '/showaccount',
                    name: 'ShowAccount',
                    component: () => import('../view/account/accountpreview.vue'),
                    meta: {
                        auth: AuthenticationStatus.NEED
                    }

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


    let auth = to.meta?.auth || AuthenticationStatus.NORMAL;
    if (auth === AuthenticationStatus.NORMAL) next();
    if (auth === AuthenticationStatus.BEFORE && !store.state.auth.authenticated) next();
    if (auth === AuthenticationStatus.NEED && store.state.auth.authenticated) next();


});
export default router;