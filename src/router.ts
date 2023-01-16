import { createRouter, createWebHistory } from 'vue-router'
import Login from '@/pages/Login.vue'
const routes = [
  {
    path: '/',
    name: 'Login',
    component: Login,
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: () => import('@/pages/Dashboard.vue'),
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      return {
        el: to.hash,
      }
    }
  },
})

export default router
