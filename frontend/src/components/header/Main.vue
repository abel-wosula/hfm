<template>
  <header>
    <nav class="bg-gray-800 dark:bg-dark py-6">
      <div
        class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl"
      >
        <!-- Logo -->
        <RouterLink to="/" class="flex items-center">
          <img
            src="../../assets/logo.png"
            class="mr-5 h-8 sm:h-10"
            alt="HFM Logo"
          />
          <span
            class="self-center text-xl font-semibold whitespace-nowrap text-white"
          >
            Holy Family Media
          </span>
        </RouterLink>

        <div class="flex items-center lg:order-2">
          <RouterLink
            to="/services"
            class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800"
          >
            Get started
          </RouterLink>
        </div>

        <!-- Navigation Menu -->
        <div
          class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1"
          id="mobile-menu-2"
        >
          <ul
            class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0"
          >
            <li v-for="(route, key) in routes" :key="key">
              <RouterLink
                :to="route.path"
                :class="{
                  'text-white bg-primary-700 lg:text-primary-700':
                    activeLink === key,
                  'text-gray-500 dark:text-gray-300 lg:hover:text-primary-700 dark:hover:text-white':
                    activeLink !== key,
                }"
                class="block py-2 pr-4 pl-3 rounded lg:bg-transparent lg:p-0 dark:text-white"
              >
                {{ route.label }}
              </RouterLink>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
</template>

<script setup>
import { RouterLink } from "vue-router";

defineProps({
  activeLink: {
    type: String,
    default: "home",
  },
});

const routes = {
  home: { path: "/", label: "Home" },
  services: { path: "/services", label: "Services" },
  portfolio: { path: "/portfolio", label: "Portfolio" },
  team: { path: "/team", label: "Team" },
  music: { path: "/music", label: "Our Music" },
  // account: { path: "/account", label: "My Account" },
  contact: { path: "/contact", label: "Contact" },
  // events: { path: "/events", label: "Events" },
};
</script>
