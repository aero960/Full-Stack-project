import Vue from "vue"
import store from '../components/store/webstore.js'
import App from "../components/app.vue"
import router from '../components/routes/webroutes.js'
import VueMask from 'v-mask'
import Vuelidate from 'vuelidate'
Vue.use(VueMask);
Vue.use(Vuelidate);





 new Vue({
    router,
    store,
    render: h => h(App)
}).$mount("#app");
