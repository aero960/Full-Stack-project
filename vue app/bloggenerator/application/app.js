import Vue from '../class/addProporties.js'
import store from '../components/store/webstore.js'
import App from "../components/app.vue"
import router from '../components/routes/webroutes.js'
import VueMask from 'v-mask'
import AsyncComputed from 'vue-async-computed'

import Vuelidate from 'vuelidate'

Vue.use(VueMask);
Vue.use(Vuelidate);
Vue.use(AsyncComputed);


let Initialize = async()=>{
    await store.dispatch('automaticalyLogin');

    new Vue({
        store,
        router,
        render: h => h(App)
    }).$mount("#app");

}





Initialize();




