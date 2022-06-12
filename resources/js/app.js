require('./bootstrap');

import {createApp} from "vue";
import {createWebHistory, createRouter} from "vue-router";
import {routes} from './router';
import main from "./Pages/Main";



const router = createRouter({
    history: createWebHistory(),
    routes,
})


const app = createApp(main);



app.use(router).mount("#app");

export default app;
