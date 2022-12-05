require('./bootstrap');

window.Vue = require('vue').default;

import Vue from "vue";
import VueRouter from "vue-router";
import Vuelidate from "vuelidate";

Vue.use(VueRouter);
Vue.use(Vuelidate);

import App from "./components/App";
import Home from "./components/Home";
import Categories from "./components/Categories";
import Products from "./components/Products";

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "home",
            component: Home,
        },
        {
            path: "/categories",
            name: "categories",
            component: Categories,
        },
        {
            path: "/products",
            name: "products",
            component: Products,
        },
    ],
})

const app = new Vue({
    el: '#app',
    components: {App},
    router,
});
