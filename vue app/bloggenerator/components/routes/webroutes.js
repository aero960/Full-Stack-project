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
        {
            path: '/postmanage',
            name: 'PostManage',
            meta: {
                auth: AuthenticationStatus.NEED
            },
            component: () => import("../view/post/postmanage.vue"),
            children:[
                {
                    path: 'createpost',
                    name:"CreatePost",
                    components:{
                        PostAction: ()=> import('../post/postadd.vue')
                    },
                    meta: {
                        auth: AuthenticationStatus.NEED
                    },
                },
                {
                    path: 'yourposts',
                    name:"CRUDPost",
                    meta: {
                        auth: AuthenticationStatus.NEED
                    },
                    components:{
                        PostAction: ()=> import('../post/postcrud.vue')
                    }
                },
                {
                    path: 'updatepost/:postId',
                    name:"UpdatePost",
                    meta: {
                        auth: AuthenticationStatus.NEED
                    },
                    components:{
                        PostAction: ()=> import('../post/postcrud.vue'),
                        PostOperation: ()=>import('../post/postoperations.vue')
                    }
                }

            ]

        },
        {
                path:'/users',
            name:'Users',
            component: ()=> import('../view/users/usersview.vue'),
            children:[
                {
                    path: ':userId',
                    name: 'ActiveUser',
                    components:{
                        user: ()=> import('../view/users/usersactive.vue')
                    },
                }

            ]
        },
        , {
        /*
            * Post manage routes*/
            path: '/post',
            name: 'Posts',
            components: {
                default:   () => import("../view/post/postview.vue"),
            },
            children: [
                {
                    path: ':postId',
                    name: 'ActivePost',
                    components:{
                        ActivePost:() => import('../view/post/postactivet.vue')
                    }
                },

            ]
        },
        {
            /*
            * Account manage routes*/
            path: '/account',
            name: 'AccountManage',
            component: () => import('../view/account/accountmanage.vue'),
            children: [
                {
                    /*
                    * Route to login current user
                    *  */
                    path: '/login',
                    name: 'LoginUser',
                    component: () => import('../view/account/accountlogin.vue'),
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
                    component: () => import('../view/account/accountregister.vue'),
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
                    component: () => import('../view/account/accountupdate.vue'),
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