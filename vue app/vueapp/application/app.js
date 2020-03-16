import Vue from "vue"
import App from "../object/helloworldvue.vue"
import bootstrap from "bootstrap/scss/bootstrap.scss"

Vue.config.productionTip = true;


const app = document.querySelector("#app");
const druga = document.querySelector("#druga");

/* eslint-disable no-new */
//document.querySelector("#")
new Vue({
    el: app,
    render: h => h(App)
})
new Vue({
    el: druga,
    render: h => h(App)
})

