import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Events from '../views/Events.vue'
import Groups from '../views/Groups.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/', 
    name: 'Home',
    component: Home
  },
  {
    path: '/events',
    name: 'Events',
    component: Events
  },
  {
    path: '/organizations',
    name: 'Organizations',
    // alias: '/orgs',
    component: () => import('../views/Groups.vue'),
    props: {
      'group_type': {
        plural: 'organizations',
        singular: 'organization'
      }
    }
  },
  {
    path: '/communities',
    name: 'Communities',
    component: () => import('../views/Groups.vue'),
    props: {
      'group_type': {
        plural: 'communities',
        singular: 'community'
      }
    }
  },
  {
    path: '/sanctuaries',
    name: 'Sanctuaries',
    component: () => import('../views/Groups.vue'),
    props: {
      'group_type':  {
        plural: 'sanctuaries',
        singular: 'sanctuary'
      }
    }
  },
  {
    path: '/groups',
    name: 'Groups',
    component: Groups
  },
  {
    path: '/about',
    name: 'About',
    component: () => import('../views/About.vue')
  },
  {
    path: '/resources',
    name: 'Resources',
    component: () => import('../views/Resources.vue')
  },
  {
    path: '/calculator',
    name: 'Calculator',
    component: () => import('../views/Calculator.vue')
  },
  {
    path: '/emojis',
    name: 'Emojis',
    component: () => import('../views/Vemoji.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
