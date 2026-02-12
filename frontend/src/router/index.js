import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/home/Main.vue";
import Portfolio from "../views/portfolio/index/Main.vue";
import Contact from "../views/contact/index/Main.vue";
import Music from "../views/music/index/Main.vue";
import Team from "../views/team/index/Main.vue";
import Event from "../views/events/index/Main.vue";
import Service  from "../views/services/index/Main.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: Home,
    },
    {
      path: "/services",
      name: "services",
      component: Service,
    },
    {
      path: "/portfolio",
      name: "portfolio",
      component: Portfolio,
    },
    {
      path: "/contact",
      name: "contact",
      component: Contact,
    },
    {
      path: "/music",
      name: "music",
      component: Music,
    },
    {
      path: "/team",
      name: "team",
      component: Team,
    },
    {
      path: "/events",
      name: "events",
      component: Event,
    },
  ],
});

export default router;
