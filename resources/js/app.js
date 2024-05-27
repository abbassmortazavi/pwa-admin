import './bootstrap';

import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js'
import 'admin-lte/dist/js/adminlte.min.js'
import Swal from "sweetalert2";
import 'sweetalert2/dist/sweetalert2.css';

import {createApp} from 'vue/dist/vue.esm-bundler.js';
import {createRouter, createWebHistory} from "vue-router";
import routes from "./routes.js";

const app = createApp({})
const router = createRouter({
    routes: routes,
    history: createWebHistory(),
})


const toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});
window.toast = toast;

app.use(router)

app.mount('#app')
