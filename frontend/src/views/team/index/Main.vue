<template>
  <Header activeLink="team" />
  <section class="bg-white dark:bg-gray-900 pt-20 pb-12 lg:pt-[120px] lg:pb-[90px]">
    <div class="container mx-auto px-4">
      <!-- Header Section -->
      <div class="mx-auto max-w-3xl text-center mb-12 lg:mb-16">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
          Our Team
        </h2>
        <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400">
          Meet our dedicated team committed to delivering exceptional quality in music and video production.
        </p>
      </div>

      <!-- Loading State -->
      <div v-if="servicesLoading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
        <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">Loading team members...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="text-center py-12">
        <div class="inline-block text-red-500 text-5xl mb-4">⚠️</div>
        <h3 class="text-2xl font-bold text-red-600 dark:text-red-400 mb-2">Unable to Load Team</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-4">Please try again later or contact support.</p>
        <button
          @click="refreshTeam"
          class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition"
        >
          Retry
        </button>
      </div>

      <!-- Team Grid -->
      <div v-else>
        <!-- No Team Members State -->
        <div v-if="!team || team.length === 0" class="text-center py-12">
          <div class="inline-block text-gray-400 text-5xl mb-4">👥</div>
          <h3 class="text-2xl font-bold text-gray-600 dark:text-gray-400 mb-2">No Team Members Yet</h3>
          <p class="text-gray-600 dark:text-gray-400">Check back soon to meet our team.</p>
        </div>

        <!-- Team Grid -->
        <div v-else class="grid gap-6 md:gap-8 md:grid-cols-2 lg:grid-cols-3">
          <div
            v-for="(member, index) in team"
            :key="member.id || index"
            class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700"
          >
            <!-- Image Container -->
            <div class="relative h-64 md:h-72 overflow-hidden">
              <!-- Default avatar if thumbnail fails -->
              <div
                v-if="!member.thumbnail"
                class="absolute inset-0 bg-gradient-to-br from-primary/20 to-primary/10 flex items-center justify-center"
              >
                <div class="w-24 h-24 rounded-full bg-primary/30 flex items-center justify-center">
                  <span class="text-4xl text-white">👤</span>
                </div>
              </div>
              
              <!-- Team Member Photo -->
              <img
                :src="getImageUrl(member.thumbnail)"
                :alt="`${member.first_name} ${member.last_name}`"
                :title="`${member.first_name} ${member.last_name} - ${member.title}`"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                @error="handleImageError"
                loading="lazy"
              />
              
              <!-- Overlay gradient on hover -->
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
              
              <!-- Social Links (optional - you can add later) -->
              <!--
              <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <a href="#" class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition">
                  <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-blue-400 hover:text-white transition">
                  <i class="fab fa-twitter"></i>
                </a>
              </div>
              -->
            </div>

            <!-- Team Member Info -->
            <div class="p-6 text-center">
              <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mb-2">
                {{ member.first_name }} {{ member.last_name }}
              </h3>
              
              <div class="mb-4">
                <span class="inline-block px-4 py-1 bg-primary/10 text-primary dark:text-primary-light rounded-full text-sm font-medium">
                  {{ member.title || 'Team Member' }}
                </span>
              </div>

              <!-- Description (if available in your model) -->
              <p v-if="member.description" class="text-gray-600 dark:text-gray-400 text-sm md:text-base line-clamp-3">
                {{ member.description }}
              </p>

              <!-- Additional Info (if available) -->
              <div v-if="member.skills || member.experience" class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                <div v-if="member.skills" class="mb-2">
                  <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Skills</p>
                  <p class="text-sm text-gray-700 dark:text-gray-300">{{ member.skills }}</p>
                </div>
                <div v-if="member.experience" class="text-sm text-gray-600 dark:text-gray-400">
                  {{ member.experience }} years experience
                </div>
              </div>

              <!-- Contact Button (optional) -->
              <!--
              <button class="mt-6 w-full py-2 bg-transparent border border-primary text-primary rounded-lg hover:bg-primary hover:text-white transition">
                Contact {{ member.first_name }}
              </button>
              -->
            </div>
          </div>
        </div>
      </div>

      <!-- Call to Action -->
      <div class="mt-16 text-center">
        <div class="bg-gradient-to-r from-primary/10 to-primary/5 rounded-2xl p-8 md:p-12">
          <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">
            Want to Join Our Team?
          </h3>
          <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-2xl mx-auto">
            We're always looking for passionate individuals to join our creative team. 
            If you share our vision for excellence in media production, we'd love to hear from you.
          </p>
          <router-link
            to="/contact"
            class="inline-flex items-center gap-2 bg-primary text-white px-8 py-3 rounded-lg font-medium hover:bg-primary-dark transition-colors duration-300"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Get In Touch
          </router-link>
        </div>
      </div>
    </div>
  </section>
  <Footer />
</template>

<script setup>
import { ref, watch } from "vue";
import { useQuery } from "@vue/apollo-composable";
import Header from "@/components/header/Main.vue";
import Footer from "@/components/footer/Main.vue";
import { TEAMS_QUERY } from "@/graphql/Queries/teams.graphql";

const team = ref([]);

// Fetch team using Apollo
const { 
  loading: servicesLoading, 
  result: servicesResults, 
  error,
  refetch 
} = useQuery(TEAMS_QUERY);

// Watch for query results
watch(
  () => servicesResults.value,
  (results) => {
    console.log("Team GraphQL Response:", results);
    
    if (results?.team) {
      // Handle different possible response structures
      if (Array.isArray(results.team)) {
        team.value = results.team;
      } else if (results.team.data) {
        team.value = results.team.data;
      } else if (results.team.edges) {
        // Handle Relay-style pagination
        team.value = results.team.edges.map(edge => edge.node);
      } else {
        team.value = [];
      }
      
      console.log("Processed Team Members:", team.value);
    } else {
      console.log("No data returned from query", results);
      team.value = [];
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
  const baseUrl = import.meta.env.VITE_API_URL || 'https://holyfamilymedia.org/laravel/public/graphql';
  
  // Remove any leading slashes
  const finalPath = cleanPath.replace(/^\//, '');
  
  // Construct the final URL
  const imageUrl = `${baseUrl}/storage/${finalPath}`;
  
  console.log("Team Image URL constructed:", {
    original: thumbnail,
    cleaned: cleanPath,
    finalPath: finalPath,
    imageUrl: imageUrl
  });
  
  return imageUrl;
};

// Handle image loading errors
const handleImageError = (event) => {
  console.warn("Failed to load team member image:", event.target.src);
  // Hide the broken image
  event.target.style.display = 'none';
  
  // Show the default avatar container
  const parent = event.target.parentElement;
  if (parent) {
    // Find or create the default avatar div
    let defaultAvatar = parent.querySelector('.default-avatar');
    if (!defaultAvatar) {
      defaultAvatar = document.createElement('div');
      defaultAvatar.className = 'default-avatar absolute inset-0 bg-gradient-to-br from-primary/20 to-primary/10 flex items-center justify-center';
      defaultAvatar.innerHTML = `
        <div class="w-24 h-24 rounded-full bg-primary/30 flex items-center justify-center">
          <span class="text-4xl text-white">👤</span>
        </div>
      `;
      parent.appendChild(defaultAvatar);
    }
    defaultAvatar.style.display = 'flex';
  }
};

// Refresh team data
const refreshTeam = async () => {
  try {
    await refetch();
  } catch (err) {
    console.error("Failed to refresh team:", err);
  }
};
</script>

<style scoped>
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
    gap: 1.5rem;
  }
  
  .h-64 {
    height: 16rem;
  }
}
</style>