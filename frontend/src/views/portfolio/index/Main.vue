<template>
  <Header activeLink="portfolio" />
  <section class="bg-white dark:bg-gray-900 pt-20 pb-12 lg:pt-[120px] lg:pb-[90px]">
    <div class="container mx-auto px-4">
      <!-- Header Section -->
      <div class="mx-auto max-w-3xl text-center mb-12 lg:mb-16">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
          Our Portfolio
        </h2>
        <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400">
          Explore our past projects showcasing Holy Family Media's expertise in music and video production.
        </p>
      </div>

      <!-- Loading State -->
      <div v-if="portfoliosLoading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
        <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">Loading portfolio projects...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="text-center py-12">
        <div class="inline-block text-red-500 text-5xl mb-4">⚠️</div>
        <h3 class="text-2xl font-bold text-red-600 dark:text-red-400 mb-2">Unable to Load Portfolio</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-4">Please try again later or contact support.</p>
        <button
          @click="refreshPortfolios"
          class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition"
        >
          Retry
        </button>
      </div>

      <!-- Portfolio Grid -->
      <div v-else>
        <!-- No Portfolio Items State -->
        <div v-if="!portfolios || portfolios.length === 0" class="text-center py-12">
          <div class="inline-block text-gray-400 text-5xl mb-4">📁</div>
          <h3 class="text-2xl font-bold text-gray-600 dark:text-gray-400 mb-2">No Portfolio Projects Yet</h3>
          <p class="text-gray-600 dark:text-gray-400">Check back soon to see our latest work.</p>
        </div>

        <!-- Portfolio Grid -->
        <div class="grid gap-6 md:gap-8 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
          <div
            v-for="portfolio in portfolios"
            :key="portfolio.id"
            class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700"
          >
            <!-- Thumbnail Container with YouTube Play Button -->
            <div class="relative h-48 md:h-56 overflow-hidden">
              <!-- Default image if thumbnail fails -->
              <div
                v-if="!portfolio.thumbnail"
                class="absolute inset-0 bg-gradient-to-br from-primary/20 to-primary/10 flex items-center justify-center"
              >
                <span class="text-4xl">🎬</span>
              </div>
              
              <!-- Portfolio Thumbnail -->
              <img
                :src="getImageUrl(portfolio.thumbnail)"
                :alt="portfolio.title"
                :title="portfolio.title"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                @error="handleImageError"
                loading="lazy"
              />
              
              <!-- YouTube Play Button Overlay -->
              <div 
                v-if="portfolio.yt_link"
                class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer"
                @click="redirectToYouTube(portfolio.yt_link)"
              >
                <div class="w-16 h-16 md:w-20 md:h-20 bg-red-600 rounded-full flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                  <svg class="w-8 h-8 md:w-10 md:h-10 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                  </svg>
                </div>
              </div>
              
              <!-- Category Badge -->
              <div class="absolute top-4 left-4">
                <span class="bg-primary text-white text-xs font-semibold px-3 py-1 rounded-full">
                  {{ getCategoryFromLink(portfolio.yt_link) || 'Video' }}
                </span>
              </div>
            </div>

            <!-- Portfolio Content -->
            <div class="p-5 md:p-6">
              <!-- Title -->
              <h3 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2">
                {{ portfolio.title }}
              </h3>

              <!-- Description -->
              <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3">
                {{ portfolio.description || 'No description available' }}
              </p>

              <!-- YouTube Link Info -->
              <div v-if="portfolio.yt_link" class="mb-4">
                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                  <svg class="w-4 h-4 mr-2 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                  </svg>
                  <span>YouTube Video Available</span>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="flex flex-wrap gap-3">
                <!-- Watch on YouTube Button -->
                <button
                  v-if="portfolio.yt_link"
                  @click="redirectToYouTube(portfolio.yt_link)"
                  class="flex-1 min-w-[140px] bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition flex items-center justify-center gap-2"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                  </svg>
                  Watch
                </button>

                <!-- View Details Button (if you have a detail page) -->
                <!--
                <button
                  @click="viewPortfolioDetails(portfolio.id)"
                  class="flex-1 min-w-[140px] bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium py-2 px-4 rounded-lg transition flex items-center justify-center gap-2"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                  </svg>
                  Details
                </button>
                -->
              </div>

              <!-- Metadata -->
              <div v-if="portfolio.created_at" class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                  <span>Added {{ formatDate(portfolio.created_at) }}</span>
                  <span v-if="portfolio.views" class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    {{ portfolio.views }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="totalPages > 1" class="mt-12 flex justify-center">
          <nav class="flex items-center gap-2">
            <button
              :disabled="currentPage <= 1"
              @click="goToPage(currentPage - 1)"
              class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-gray-800 transition"
            >
              Previous
            </button>
            
            <div class="flex items-center gap-1">
              <button
                v-for="page in visiblePages"
                :key="page"
                @click="goToPage(page)"
                :class="[
                  'px-4 py-2 rounded-lg transition',
                  currentPage === page
                    ? 'bg-primary text-white'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800'
                ]"
              >
                {{ page }}
              </button>
              
              <span v-if="showEllipsis" class="px-2 text-gray-500">...</span>
              
              <button
                v-if="showLastPage"
                @click="goToPage(totalPages)"
                :class="[
                  'px-4 py-2 rounded-lg transition',
                  currentPage === totalPages
                    ? 'bg-primary text-white'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800'
                ]"
              >
                {{ totalPages }}
              </button>
            </div>
            
            <button
              :disabled="currentPage >= totalPages"
              @click="goToPage(currentPage + 1)"
              class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-gray-800 transition"
            >
              Next
            </button>
            
            <span class="ml-4 text-sm text-gray-500 dark:text-gray-400">
              Page {{ currentPage }} of {{ totalPages }}
            </span>
          </nav>
        </div>
      </div>

      <!-- Call to Action -->
      <div class="mt-16 text-center">
        <div class="bg-gradient-to-r from-primary/10 to-primary/5 rounded-2xl p-8 md:p-12">
          <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">
            Have a Project in Mind?
          </h3>
          <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-2xl mx-auto">
            Let's create something amazing together. Contact us to discuss your next music or video project.
          </p>
          <router-link
            to="/contact"
            class="inline-flex items-center gap-2 bg-primary text-white px-8 py-3 rounded-lg font-medium hover:bg-primary-dark transition-colors duration-300"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
            </svg>
            Start Your Project
          </router-link>
        </div>
      </div>
    </div>
  </section>
  <Footer />
</template>

<script setup>
import { ref, watch, computed } from "vue";
import { useQuery } from "@vue/apollo-composable";
import Header from "@/components/header/Main.vue";
import Footer from "@/components/footer/Main.vue";
import { PORTFOLIOS_QUERY } from "@/graphql/Queries/portfolios.graphql";

const portfolios = ref([]);
const currentPage = ref(1);
const totalPages = ref(1);
const itemsPerPage = 8; // You can adjust this

// Fetch portfolios using Apollo
const { 
  loading: portfoliosLoading, 
  result: portfoliosResults, 
  error,
  refetch 
} = useQuery(PORTFOLIOS_QUERY, () => ({
  page: currentPage.value,
  first: itemsPerPage
}));

// Watch for query results
watch(
  () => portfoliosResults.value,
  (results) => {
    console.log("Portfolio GraphQL Response:", results);
    
    if (results?.portfolios) {
      if (results.portfolios.data) {
        portfolios.value = results.portfolios.data;
      } else if (Array.isArray(results.portfolios)) {
        portfolios.value = results.portfolios;
      } else {
        portfolios.value = [];
      }
      
      // Update pagination info
      if (results.portfolios.paginatorInfo) {
        totalPages.value = results.portfolios.paginatorInfo.lastPage || 1;
      }
      
      console.log("Processed Portfolios:", portfolios.value);
    } else {
      console.log("No data returned from query", results);
      portfolios.value = [];
      totalPages.value = 1;
    }
  },
  { immediate: true }
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
  const baseUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000';
  
  // Remove any leading slashes
  const finalPath = cleanPath.replace(/^\//, '');
  
  // Construct the final URL
  const imageUrl = `${baseUrl}/storage/${finalPath}`;
  
  console.log("Portfolio Image URL constructed:", {
    original: thumbnail,
    cleaned: cleanPath,
    finalPath: finalPath,
    imageUrl: imageUrl
  });
  
  return imageUrl;
};

// Handle image loading errors
const handleImageError = (event) => {
  console.warn("Failed to load portfolio image:", event.target.src);
  // Hide the broken image
  event.target.style.display = 'none';
  
  // Show the default image container
  const parent = event.target.parentElement;
  if (parent) {
    // Find or create the default image div
    let defaultImage = parent.querySelector('.default-image');
    if (!defaultImage) {
      defaultImage = document.createElement('div');
      defaultImage.className = 'default-image absolute inset-0 bg-gradient-to-br from-primary/20 to-primary/10 flex items-center justify-center';
      defaultImage.innerHTML = '<span class="text-4xl">🎬</span>';
      parent.appendChild(defaultImage);
    }
    defaultImage.style.display = 'flex';
  }
};

// Extract category from YouTube link (optional)
const getCategoryFromLink = (link) => {
  if (!link) return null;
  
  // You can extract categories based on YouTube URL patterns
  // This is just an example - customize based on your needs
  if (link.includes('/playlist/')) return 'Playlist';
  if (link.includes('/channel/')) return 'Channel';
  if (link.includes('/user/')) return 'User';
  if (link.includes('/watch')) return 'Video';
  
  return 'Media';
};

// Format date
const formatDate = (dateString) => {
  if (!dateString) return 'recently';
  const date = new Date(dateString);
  const now = new Date();
  const diffTime = Math.abs(now - date);
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
  
  if (diffDays === 1) return 'yesterday';
  if (diffDays < 7) return `${diffDays} days ago`;
  if (diffDays < 30) return `${Math.floor(diffDays / 7)} weeks ago`;
  
  return date.toLocaleDateString('en-US', { 
    year: 'numeric', 
    month: 'short' 
  });
};

// Redirect to YouTube
const redirectToYouTube = (videoUrl) => {
  if (videoUrl) {
    window.open(videoUrl, "_blank", "noopener,noreferrer");
  } else {
    console.warn("No YouTube URL provided");
  }
};

// View portfolio details (if you have a detail page)
const viewPortfolioDetails = (id) => {
  // Uncomment and implement if you have a portfolio detail page
  // router.push({ name: 'PortfolioDetail', params: { id: String(id) } });
  console.log('View portfolio details:', id);
};

// Refresh portfolios
const refreshPortfolios = async () => {
  try {
    await refetch();
  } catch (err) {
    console.error("Failed to refresh portfolios:", err);
  }
};

// Pagination functions
const goToPage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
};

// Pagination UI helpers
const visiblePages = computed(() => {
  const pages = [];
  const maxVisible = 5;
  
  if (totalPages.value <= maxVisible) {
    // Show all pages
    for (let i = 1; i <= totalPages.value; i++) {
      pages.push(i);
    }
  } else {
    // Show limited pages
    let start = Math.max(1, currentPage.value - 2);
    let end = Math.min(totalPages.value, start + maxVisible - 1);
    
    // Adjust if we're near the end
    if (end - start + 1 < maxVisible) {
      start = Math.max(1, end - maxVisible + 1);
    }
    
    for (let i = start; i <= end; i++) {
      pages.push(i);
    }
  }
  
  return pages;
});

const showEllipsis = computed(() => {
  return totalPages.value > 5 && currentPage.value < totalPages.value - 2;
});

const showLastPage = computed(() => {
  return totalPages.value > 5 && currentPage.value < totalPages.value - 1;
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

/* Smooth hover effects */
.group:hover .group-hover\:scale-110 {
  transform: scale(1.1);
}

/* Ensure images maintain aspect ratio */
img {
  max-width: 100%;
  height: auto;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .grid {
    gap: 1rem;
  }
  
  .h-48 {
    height: 12rem;
  }
}
</style>