import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'

Vue.use(Router)

export default new Router({
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/sites/index',
      name: 'sites.index',
      component: () => import('./views/Sites/SitesIndex.vue'),
    },
    {
      path: '/sites/new',
      name: 'sites.new',
      component: () => import('./views/Sites/SitesForm.vue'),
    },
    {
      path: '/sites/:id',
      name: 'sites.edit',
      component: () => import('./views/Sites/SitesForm.vue'),
      props: true
    },
    {
      path: '/staff/index',
      name: 'staff.index',
      component: () => import('./views/Staff/StaffIndex.vue'),
    },
    {
      path: '/staff/new',
      name: 'staff.new',
      component: () => import('./views/Staff/StaffForm.vue'),
    },
    {
      path: '/staff/:id',
      name: 'staff.edit',
      component: () => import('./views/Staff/StaffForm.vue'),
      props: true
    },
    {
      path: '/orders/index',
      name: 'orders.index',
      component: () => import('./views/Orders/OrdersIndex.vue')
    },
    {
      path: '/calls/index',
      name: 'calls.index',
      component: () => import('./views/Calls/CallsIndex.vue')
    },
    {
      path: '/visits/index',
      name: 'visits.index',
      component: () => import('./views/Visits/VisitsIndex.vue')
    },
    {
      path: '/tables',
      name: 'tables',
      component: () => import('./views/Tables.vue')
    },
    {
      path: '/forms',
      name: 'forms',
      component: () => import('./views/Forms.vue')
    },
    {
      path: '/profile',
      name: 'profile',
      component: () => import('./views/Profile.vue')
    },
    {
      path: '/clients/index',
      name: 'clients.index',
      component: () => import('./views/Clients/ClientsIndex.vue'),
    },
    {
      path: '/clients/new',
      name: 'clients.new',
      component: () => import('./views/Clients/ClientsForm.vue'),
    },
    {
      path: '/clients/:id',
      name: 'clients.edit',
      component: () => import('./views/Clients/ClientsForm.vue'),
      props: true
    }
  ],
  scrollBehavior (to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { x: 0, y: 0 }
    }
  }
})
