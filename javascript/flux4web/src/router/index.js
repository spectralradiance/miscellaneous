import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home.vue";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home,
  },
  {
    path: "/writing",
    name: "writing",
    component: () => import("../views/Writing.vue"),
  },
  {
    path: "/photography",
    name: "photography",
    component: () => import("../views/Photography.vue"),
  },
  {
    path: "/inspiration",
    name: "inspiration",
    component: () => import("../views/Inspiration.vue"),
  },
  {
    path: "/programming",
    name: "Programming",
    component: () => import("../views/Menu.vue"),
    props: {
      title: "Programming",
      menu: [
        {
          name: "CodePen",
          path: "/codepen",
        },
        {
          name: "GitHub",
          path: "/github",
        },
        {
          name: "Vegan Projects",
          path: "/programming/vegan",
        },
      ],
    },
  },
  {
    path: "/codepen",
    name: "CodePen",
    beforeEnter() {
      location.href = "https://codepen.io/flux4";
    },
  },
  {
    path: "/github",
    name: "GitHub",
    beforeEnter() {
      location.href = "https://github.com/flux4";
    },
  },
  {
    path: "/programming/vegan",
    name: "Vegan Projects",
    component: () => import("../views/Menu.vue"),
    props: {
      title: "Vegan Projects",
      menu: [
        {
          name: "Calculator",
          path: "/programming/vegan/calculator",
        },
        {
          name: "Resources",
          path: "/programming/vegan/resources",
        },
        {
          name: "Vemoji",
          path: "/programming/vegan/vemoji",
        },
      ],
    },
  },
  {
    path: "/programming/vegan/calculator",
    name: "Calculator",
    component: () => import("../views/vegan/Calculator.vue"),
  },
  {
    path: "/programming/vegan/resources",
    name: "Resources",
    component: () => import("../views/vegan/Resources.vue"),
  },
  {
    path: "/programming/vegan/vemoji",
    name: "Vemoji",
    component: () => import("../views/vegan/Vemoji.vue"),
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

export default router;
