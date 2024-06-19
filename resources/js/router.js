import { popScopeId } from "vue";
import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        name: "Home",
        component: () => import("./pages/Home.vue"),
    },
    {
        path: "/login",
        name: "Login",
        component: () => import("./pages/Login.vue"),
    },
    {
        path: "/register",
        name: "Register",
        component: () => import("./pages/Register.vue"),
    },
    {
        path: "/register_product",
        name: "NewProduct",
        component: () => import("./pages/RegisterProduct.vue"),
    },
    {
        path: "/update_product/:id",
        name: "EditProduct",
        component: () => import("./pages/EditProduct.vue"),
        props:true,
    }
];

export default createRouter({
    history: createWebHistory(),
    routes,
});