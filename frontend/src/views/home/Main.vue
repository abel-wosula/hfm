<template>
  <div>
    <Header activeLink="home" />

    <!-- ================= HERO WITH SLIDER ================= -->
    <section v-if="heroSection" class="bg-blue-100 dark:bg-gray-900">
      <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
        <!-- Left column: dynamic content from first section -->
        <div class="mr-auto place-self-center lg:col-span-7">
          <div class="container mx-auto max-w-4xl relative z-10">
            <h2
              v-if="heroSection.title"
              class="text-4xl font-bold mb-4"
              :class="[
                heroSection.text_align,
                heroSection.background_image ? 'text-white' : 'text-gray-900'
              ]"
            >
              {{ heroSection.title }}
            </h2>

            <p
              v-if="heroSection.subtitle"
              class="text-xl mb-6"
              :class="[
                heroSection.text_align,
                heroSection.background_image ? 'text-white/90' : 'text-gray-600'
              ]"
            >
              {{ heroSection.subtitle }}
            </p>

            <div
              v-if="heroSection.content"
              class="prose max-w-none mb-8"
              :class="[
                heroSection.text_align,
                heroSection.background_image ? 'text-white' : ''
              ]"
              v-html="heroSection.content"
            ></div>

            <div class="flex flex-wrap gap-4" :class="heroSection.text_align">
              <router-link
                v-if="heroSection.button_text"
                :to="heroSection.button_link || '/'"
                class="px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
              >
                {{ heroSection.button_text }}
              </router-link>

              <router-link
                v-if="heroSection.button_secondary_text"
                :to="heroSection.button_secondary_link || '/'"
                class="px-6 py-3 rounded transition"
                :class="heroSection.background_image
                  ? 'border border-white text-white hover:bg-white/20'
                  : 'border border-gray-300 text-gray-800 hover:bg-gray-100'"
              >
                {{ heroSection.button_secondary_text }}
              </router-link>
            </div>
          </div>
        </div>

        <!-- Right column: image slider -->
        <div class="hidden lg:mt-0 lg:col-span-5 lg:flex lg:relative">
          <div class="relative w-full h-auto">
            <!-- Slide image -->
            <img
              :src="slides[currentSlide]"
              alt="Slider image"
              class="w-full h-auto rounded-lg shadow-xl"
            />

            <!-- Overlay for controls background -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2 bg-black/30 px-3 py-1 rounded-full">
              <!-- Dots -->
              <span
                v-for="(s, i) in slides"
                :key="i"
                @click="goToSlide(i)"
                class="w-3 h-3 rounded-full cursor-pointer transition-all"
                :class="i === currentSlide ? 'bg-white scale-125' : 'bg-white/40 hover:bg-white/60'"
              ></span>
            </div>

            <!-- Arrows -->
            <button
              @click="prevSlide"
              class="absolute left-2 top-1/2 -translate-y-1/2 text-white text-4xl z-10 hover:opacity-75 bg-black/20 w-10 h-10 flex items-center justify-center rounded-full"
            >
              ‹
            </button>
            <button
              @click="nextSlide"
              class="absolute right-2 top-1/2 -translate-y-1/2 text-white text-4xl z-10 hover:opacity-75 bg-black/20 w-10 h-10 flex items-center justify-center rounded-full"
            >
              ›
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= LOADING ================= -->
    <div v-if="loading" class="min-h-screen flex items-center justify-center">
      Loading...
    </div>

    <!-- ================= ERROR ================= -->
    <div v-else-if="error" class="min-h-screen flex items-center justify-center">
      {{ error.message }}
    </div>

    <!-- ================= SECTIONS (excluding hero) ================= -->
    <div v-else>
      <section
        v-for="section in remainingSections"
        :key="section.key"
        class="py-20 relative overflow-hidden min-h-[50vh]"
        :style="{
          backgroundImage: section.background_image ? `url(${section.background_image})` : 'none',
          backgroundSize: 'cover',
          backgroundPosition: 'center',
          backgroundRepeat: 'no-repeat',
          backgroundColor: section.background_color || '#fff'
        }"
      >
        <!-- Dark overlay only if background image exists -->
        <div
          v-if="section.background_image"
          class="absolute inset-0 bg-black/50"
          aria-hidden="true"
        ></div>

        <!-- Content -->
        <div class="container mx-auto px-4 max-w-4xl relative z-10">
          <h2
            v-if="section.title"
            class="text-4xl font-bold mb-4"
            :class="[
              section.text_align,
              section.background_image ? 'text-white' : 'text-gray-900'
            ]"
          >
            {{ section.title }}
          </h2>

          <p
            v-if="section.subtitle"
            class="text-xl mb-6"
            :class="[
              section.text_align,
              section.background_image ? 'text-white/90' : 'text-gray-600'
            ]"
          >
            {{ section.subtitle }}
          </p>

          <div
            v-if="section.content"
            class="prose max-w-none mb-8"
            :class="[
              section.text_align,
              section.background_image ? 'text-white' : ''
            ]"
            v-html="section.content"
          ></div>

          <div class="flex flex-wrap gap-4" :class="section.text_align">
            <router-link
              v-if="section.button_text"
              :to="section.button_link || '/'"
              class="px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
            >
              {{ section.button_text }}
            </router-link>

            <router-link
              v-if="section.button_secondary_text"
              :to="section.button_secondary_link || '/'"
              class="px-6 py-3 rounded transition"
              :class="section.background_image
                ? 'border border-white text-white hover:bg-white/20'
                : 'border border-gray-300 text-gray-800 hover:bg-gray-100'"
            >
              {{ section.button_secondary_text }}
            </router-link>
          </div>
        </div>
      </section>
    </div>

    <Footer />
  </div>
</template>

<script setup>
import { ref, watch, computed, onMounted, onBeforeUnmount } from 'vue'
import { useQuery } from '@vue/apollo-composable'
import Header from "@/components/header/Main.vue"
import Footer from "@/components/footer/Main.vue"
import { HOMEPAGE_SECTION_QUERY } from '@/graphql/Queries/homepageSection.graphql'

// Images
import studioFam from '@/assets/images/studiofam.png'
import studioBg from '@/assets/images/studiobackgnd.webp'
import videoBg from '@/assets/images/video.webp'

// ================= SLIDER =================
const slides = [studioFam, studioBg, videoBg]
const currentSlide = ref(0)
let sliderInterval = null

const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % slides.length
}

const prevSlide = () => {
  currentSlide.value =
    (currentSlide.value - 1 + slides.length) % slides.length
}

const goToSlide = (i) => {
  currentSlide.value = i
}

const startSlider = () => {
  sliderInterval = setInterval(nextSlide, 4500)
}

const pauseSlider = () => {
  clearInterval(sliderInterval)
}

const resumeSlider = () => {
  startSlider()
}

// ================= GRAPHQL =================
const sections = ref([])
const loading = ref(true)
const error = ref(null)

const { result, loading: qLoading, error: qError } = useQuery(
  HOMEPAGE_SECTION_QUERY,
  { page: 1, first: 100 }
)

watch(result, (res) => {
  if (res?.homepage_section?.data) {
    sections.value = res.homepage_section.data
      .filter(s => s.is_active)
      .sort((a, b) => a.order - b.order)
  }
})

watch(qLoading, v => loading.value = v)
watch(qError, v => error.value = v)

// Hero section is the first section (if any)
const heroSection = computed(() => sections.value.length > 0 ? sections.value[0] : null)

// Remaining sections (after hero)
const remainingSections = computed(() => sections.value.slice(1))

// ================= LIFECYCLE =================
onMounted(startSlider)
onBeforeUnmount(() => clearInterval(sliderInterval))
</script>