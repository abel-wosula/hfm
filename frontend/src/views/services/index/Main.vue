<template>
  <Header activeLink="services" />
  <section class="pt-20 pb-12 lg:pt-[120px] lg:pb-[90px] bg-gray dark:bg-dark">
    <div class="container mx-auto">
      <!-- Hero/Intro Section -->
      <div class="-mx-4 flex flex-wrap">
        <div class="w-full px-4">
          <div class="mx-auto mb-12 max-w-[510px] text-center lg:mb-20">
            <span class="text-primary mb-2 block text-lg font-bold">
              Our Services
            </span>
            <h2
              class="text-dark dark:text-white mb-3 text-3xl leading-[1.2] font-bold sm:text-4xl md:text-[40px]"
            >
              What We Offer
            </h2>
            <p class="text-body-color text-base dark:text-dark-6">
              Holy Family Media is dedicated to providing the best quality in
              music and video production. Among our major releases, we recently
              launched a new audio and video project that showcases our
              commitment to excellence. In addition to production services, we
              engage in singing, charity services, and support for member growth
              and development.
            </p>
          </div>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="servicesLoading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
        <p class="mt-4 text-lg text-body-color dark:text-dark-6">Loading services...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="text-center py-12">
        <div class="inline-block text-red-500 text-5xl mb-4">⚠️</div>
        <h3 class="text-2xl font-bold text-red-600 dark:text-red-400 mb-2">Unable to Load Services</h3>
        <p class="text-body-color dark:text-dark-6">Please try again later or contact support.</p>
        <button
          @click="refreshServices"
          class="mt-4 px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition"
        >
          Retry
        </button>
      </div>

      <!-- Services Grid -->
      <div v-else class="-mx-4 flex flex-wrap">
        <!-- No Services State -->
        <div v-if="services.length === 0" class="w-full text-center py-12">
          <div class="inline-block text-gray-400 text-5xl mb-4">📭</div>
          <h3 class="text-2xl font-bold text-gray-600 dark:text-gray-400 mb-2">No Services Available</h3>
          <p class="text-body-color dark:text-dark-6">Check back soon for our service offerings.</p>
        </div>

        <!-- Services Grid -->
        <div
          v-else
          v-for="service in services"
          :key="service.id"
          class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8"
        >
          <div
            class="group h-full rounded-[20px] bg-white dark:bg-dark-2 p-8 shadow-lg hover:shadow-2xl transition-all duration-300 cursor-pointer border border-gray-200 dark:border-dark-3 hover:border-primary/20 overflow-hidden"
            @click="goToServiceDetail(service.id)"
          >
            <!-- Thumbnail Container -->
            <div class="relative overflow-hidden rounded-xl mb-6 h-48">
              <!-- Default image if thumbnail fails -->
              <div
                v-if="!service.thumbnail"
                class="absolute inset-0 bg-gradient-to-br from-primary/20 to-primary/10 flex items-center justify-center"
              >
                <span class="text-4xl">🎵</span>
              </div>
              
              <!-- Service Thumbnail -->
              <img
                :src="getImageUrl(service.thumbnail)"
                :alt="service.title"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                @error="handleImageError"
                loading="lazy"
              />
              
              <!-- Overlay gradient -->
              <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
              
              Read More Overlay
              <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <span class="bg-white/90 text-primary font-bold px-6 py-2 rounded-full backdrop-blur-sm">
                  Read More →
                </span>
              </div>
            </div>

            <!-- Service Content -->
            <div class="flex-grow">
              <h3
                class="text-dark dark:text-white mb-3 text-xl font-bold group-hover:text-primary transition-colors duration-300 line-clamp-2"
              >
                {{ service.title }}
              </h3>
              
              <p class="text-body-color dark:text-dark-6 mb-4 text-sm line-clamp-3">
                {{ service.short_description || 'No description available' }}
              </p>
              
              <!-- Service Tags/Categories -->
              <div v-if="service.categories && service.categories.length > 0" class="mb-4">
                <div class="flex flex-wrap gap-2">
                  <span
                    v-for="category in service.categories.slice(0, 2)"
                    :key="category"
                    class="px-3 py-1 bg-gray-100 dark:bg-dark-3 text-xs rounded-full text-body-color dark:text-dark-6"
                  >
                    {{ category }}
                  </span>
                  <span
                    v-if="service.categories.length > 2"
                    class="px-3 py-1 bg-gray-100 dark:bg-dark-3 text-xs rounded-full text-body-color dark:text-dark-6"
                  >
                    +{{ service.categories.length - 2 }} more
                  </span>
                </div>
              </div>
            </div>

            <!-- Footer with Read More -->
            <div class="pt-4 border-t border-gray-100 dark:border-dark-3 mt-4">
              <div class="flex items-center justify-between">
                <span class="text-sm text-body-color dark:text-dark-6">
                  {{ formatDate(service.created_at) }}
                </span>
                <!-- <button
                  @click.stop="goToServiceDetail(service.id)"
                  class="text-primary font-medium hover:text-primary-dark transition-colors duration-300 flex items-center gap-1"
                >
                  Read More
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                  </svg>
                </button> -->
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Call to Action Section -->
      <div v-if="services.length > 0" class="mt-16 text-center">
        <div class="bg-gradient-to-r from-primary/10 to-primary/5 rounded-2xl p-8 md:p-12">
          <h3 class="text-2xl md:text-3xl font-bold text-dark dark:text-white mb-4">
            Need a Custom Solution?
          </h3>
          <p class="text-body-color dark:text-dark-6 mb-6 max-w-2xl mx-auto">
            We specialize in creating tailored media solutions that fit your unique needs. 
            Contact us to discuss your project.
          </p>
          <router-link
            to="/contact"
            class="inline-flex items-center gap-2 bg-primary text-white px-8 py-3 rounded-lg font-medium hover:bg-primary-dark transition-colors duration-300"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            Contact Us
          </router-link>
        </div>
      </div>
    </div>
  </section>
  <Footer />
</template>

<script setup>
import { ref, computed, watch, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useQuery } from "@vue/apollo-composable";
import { SERVICES_QUERY } from "@/graphql/Queries/services.graphql";
import Header from "@/components/header/Main.vue";
import Footer from "@/components/footer/Main.vue";

const services = ref([]);
const router = useRouter();

// Fetch services using Apollo
const { 
  loading: servicesLoading, 
  result: servicesResults, 
  error,
  refetch 
} = useQuery(SERVICES_QUERY);

// Watch for query results using Vue's watch
watch(
  () => servicesResults.value,
  (results) => {
    console.log("GraphQL Response:", results);
    
    if (results?.services) {
      // Handle different possible response structures
      if (Array.isArray(results.services)) {
        services.value = results.services;
      } else if (results.services.data) {
        services.value = results.services.data;
      } else if (results.services.edges) {
        // Handle Relay-style pagination
        services.value = results.services.edges.map(edge => edge.node);
      } else {
        services.value = [];
      }
      
      console.log("Processed Services:", services.value);
    } else {
      console.log("No data returned from query", results);
      services.value = [];
    }
  },
  { immediate: true } // Run immediately on component mount
);

// Handle image URL construction
const getImageUrl = (thumbnail) => {
  if (!thumbnail) {
    return ''; // Return empty string for fallback handling
  }

  // If it's already a full URL, return as is
  if (thumbnail.startsWith("http") || thumbnail.startsWith("data:image") || thumbnail.startsWith("//")) {
    return thumbnail;
  }

  // If it starts with storage/, remove it to avoid double storage
  const cleanPath = thumbnail.replace(/^storage\//, '');
  
  // Construct the URL - adjust based on your backend URL
  // You might want to use an environment variable for the base URL
  const baseUrl = import.meta.env.VITE_API_URL || 'https://holyfamilymedia.org/laravel/public/graphql';
  const imageUrl = `${baseUrl}/storage/${cleanPath}`;
  
  console.log("Image URL constructed:", imageUrl);
  return imageUrl;
};

// Handle image loading errors
const handleImageError = (event) => {
  console.warn("Failed to load image:", event.target.src);
  event.target.style.display = 'none';
  event.target.parentElement.classList.add('bg-gradient-to-br', 'from-primary/20', 'to-primary/10');
};

// Format date
const formatDate = (dateString) => {
  if (!dateString) return 'N/A';
  const date = new Date(dateString);
  return date.toLocaleDateString('en-US', { 
    year: 'numeric', 
    month: 'short', 
    day: 'numeric' 
  });
};

// Navigate to service detail
const goToServiceDetail = (id) => {
  if (id) {
    router.push({ 
      name: "ServiceDetail", 
      params: { id: String(id) } 
    });
  } else {
    console.error("No service ID provided");
  }
};

// Refresh services
const refreshServices = async () => {
  try {
    await refetch();
  } catch (err) {
    console.error("Failed to refresh services:", err);
  }
};

// Debug: Check what the query returns
onMounted(() => {
  console.log("Services Query Hook:", {
    loading: servicesLoading.value,
    result: servicesResults.value,
    error: error.value
  });
});
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.group:hover .group-hover\:scale-105 {
  transform: scale(1.05);
}

/* Smooth transitions */
.transition-all {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 300ms;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .px-4 {
    padding-left: 1rem;
    padding-right: 1rem;
  }
  
  .mb-8 {
    margin-bottom: 2rem;
  }
}
</style>