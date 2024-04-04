import { createRouter, createWebHistory } from "vue-router";

import { initManualClass } from '../helpers/authUtils'

import pageLogin from '../components/views/Login.vue';

import pageAdminIndex from '../components/views/Index.vue';

import pageDashboard from '../components/pages/Dashboard.vue';

import pageQuestion from '../components/pages/question/Question.vue';

import pageAnswer from '../components/pages/answer/Answer.vue';

import pageMapping from '../components/pages/mapping/Mapping.vue';

import pageBehaviour from '../components/pages/behaviour/Behaviour.vue';

import pageNotFound from '../components/pages/NotFound.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: pageLogin,
    },
    {
        path: '/login',
        name: 'Login',
        component: pageLogin
    },
    {
        path: '/admin',
        name: 'AdminIndex',
        redirect: { name: 'dashboard' },
        component: pageAdminIndex,
        children: [
            {
                path: '/admin/dashboard',
                name: 'dashboard',
                component: pageDashboard
            },
            {
                path: '/admin/questions',
                name: 'question',
                component: pageQuestion
            },
            {
                path: '/admin/answers',
                name: 'answer',
                component: pageAnswer
            },
            {
                path: '/admin/mappings',
                name: 'mapping',
                component: pageMapping
            },
            {
                path: '/admin/behaviours',
                name: 'behaviour',
                component: pageBehaviour
            },
            {
                path: '',
                component: pageDashboard
            }
        ]
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: pageNotFound
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})


router.beforeEach(async (to, from) => {
    if (
        // make sure the user is authenticated
        !initManualClass().getAuthToken()
        // ❗️ Avoid an infinite redirect
        && to.name !== 'Login'
    ) {
        initManualClass().emptyStorage()
        // redirect the user to the login page
        return { name: 'Login' }
    }
})

export default router