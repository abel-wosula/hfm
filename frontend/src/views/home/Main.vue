<template>
  <Header activeLink="home" />
  <section>
    <div
      class="relative min-h-screen bg-center bg-cover flex-items-center justify-center"
      style="background-image: url('@/src/assets/home-bg.jpg')"
    >
      <div class="absolute inset-0 bg-black bg-opacity-25"></div>
      <div
        class="absolute inset-0 flex flex-col lg:flex-col items-center justify-between text-white px-8"
      >
        <!-- Top Content -->
        <div class="text-center bg-gray lg:text-center lg:w-1/2">
          <h1 class="text-3xl lg:text-3xl mb-4 mt-0 pt-20 font-bold">
            Welcome to Holy Family Media
          </h1>
          <h2 class="text-3xl lg:text-3xl font-bold mb-10">
            The fountain of holy music
          </h2>
          <div class="flex flex-col sm:flex-row gap-20 justify-center">
            <router-link
              to="/contact"
              class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-300"
            >
              Book your session today
            </router-link>
            <router-link
              to="/services"
              class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-300"
            >
              View Services
            </router-link>
          </div>
        </div>

        <!-- Booking Card -->
        <div
          class="mb-20 lg:mt-0 lg:w-96 bg-white/10 backdrop-blur-lg rounded-xl p-8 shadow-xl border border-white/20"
        >
          <h3 class="text-3xl font-bold mb-6 text-blue-200">
            Book your session today
          </h3>

          <div class="space-y-4 text-gray-200">
            <div class="flex items-center gap-3">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-blue-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                />
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                />
              </svg>
              <div>
                <p class="font-semibold">Location</p>
                <p>Holy Family Media - Thika, Kenya</p>
              </div>
            </div>

            <div class="flex items-center gap-3">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-blue-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                />
              </svg>
              <div>
                <p class="font-semibold">Contact</p>
                <p>+254 708 026 652</p>
              </div>
            </div>

            <div class="mt-6 bg-blue-800/30 p-4 rounded-lg">
              <p class="text-sm italic text-blue-100">
                "Samuel Magima Family and Friends Choir - Creating divine
                melodies for spiritual upliftment since 2015"
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <Footer />
</template>

<script setup>
import Header from "@/components/header/Main.vue";
import Footer from "@/components/footer/Main.vue";
</script>
