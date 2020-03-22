import Vue from "vue"
import App from "../components/app.vue"
import Router from "vue-router"
import store from "../store/Store.js"
import bootstrap from "bootstrap/scss/bootstrap.scss"

Vue.config.productionTip = true;
Vue.use(Router);




new Vue({
    store,
    el: document.querySelector("#app"),
    render: h => h(App)
})
