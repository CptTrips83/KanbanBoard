import { createRouter, createWebHistory } from 'vue-router';
import HomePage from "../pages/HomePage.vue";
import TestPage from "../pages/TestPage.vue";

const index = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/home",
            component: HomePage,
        },
        {
            path: "/home/test",
            component: TestPage,
        },
        {
            path: "/home/board",
            component: () =>
                import(/* webpackChunkName: 'component-boardpage' */ "../pages/BoardPage.vue"),
        },
        {
            path: "/home/board/task/:taskId",
            component: () =>
                import( "../pages/BoardPage.vue"),
        }
    ]
})

export default index;
