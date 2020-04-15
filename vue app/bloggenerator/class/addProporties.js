import Vue from 'vue'
import {PostManaging} from "../class/post/post";

Object.defineProperty(Vue.prototype, '$postManage', {get: () => PostManaging});




export default  Vue;