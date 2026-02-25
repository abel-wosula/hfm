<template>
  <Header activeLink="music" />
  <div class="max-w-1/2 bg-white p-4 mx-auto min-h-screen">
    <div class="mx-auto max-w-screen-sm text-center mb-2 lg:mb-8">
      <h2
        class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white"
      >
        Our Music
      </h2>
      <p class="font-light text-gray-700 lg:mb-4 sm:text-xl dark:text-gray-400">
        Download your audio and music sheets from this page.
      </p>
    </div>
    <div class="grid grid-cols-12 items-center gap-2">
      <div class="filters col-span-12 p-1 flex flex-row">
        <div class="flex items-start justify-between w-full">
          <div class="form-group flex flex-row items-center">
            <label for="search" class="mr-2">Search</label>
            <input
              type="text"
              id="search"
              class="w-full p-1 border border-gray-400 rounded-lg"
              v-model="filters.search"
              @input="debouncedFetchData"
              placeholder="Search music..."
            />
          </div>
        </div>
      </div>
      <div class="col-span-12 p-3">
        <table
          class="w-full text-sm table mx-3 items-start bg-blue-200 p-4 rounded-lg"
        >
          <thead class="border-b border-gray-600 font-semibold bg-slate-300">
            <tr>
              <th class="p-3 text-left">Music Title</th>
              <th class="p-3 text-left">Audio</th>
              <th class="p-3 text-left">Composer</th>
              <th class="p-3 text-left">Score Sheet</th>
              <th class="p-3 text-left">YouTube Link</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="uploadRecordsLoading">
              <td colspan="5" class="py-5 text-center">
                Loading music records...
              </td>
            </tr>
            <tr v-else-if="uploadRecords.length === 0">
              <td colspan="5" class="py-5 text-center">
                No music records found
              </td>
            </tr>
            <template v-else>
              <tr
                v-for="(uploadRecord, index) in uploadRecords"
                :key="index"
                class="border-b border-opacity-20 hover:bg-blue-100 transition-colors"
              >
                <td class="px-2 py-4 font-medium">
                  {{ uploadRecord.music_title }}
                </td>
                <td class="px-2 py-4">
                  <div class="flex items-center gap-2 flex-col md:flex-row">
                    <span class="text-sm">{{
                      getFileName(uploadRecord.audio_path)
                    }}</span>
                    <audio controls class="w-48" v-if="uploadRecord.audio_path">
                      <source
                        :src="getAudioUrl(uploadRecord.audio_path)"
                        type="audio/mpeg"
                      />
                      Your browser does not support the audio element.
                    </audio>
                    <span v-else class="text-gray-500">No audio file</span>
                  </div>
                </td>
                <td class="px-2 py-4">{{ uploadRecord.composer || "N/A" }}</td>
                <td class="px-2 py-4">
                  <div class="flex flex-col gap-2">
                    <span class="text-sm">{{
                      getFileName(uploadRecord.file_path)
                    }}</span>
                    <div class="flex gap-2">
                      <a
                        v-if="uploadRecord.file_path"
                        :href="getFileUrl(uploadRecord.file_path)"
                        class="inline-flex items-center px-4 py-2 text-white bg-blue-500 hover:bg-blue-700 rounded transition-colors"
                        download
                      >
                        Download PDF
                      </a>
                      <button
                        v-if="uploadRecord.file_path"
                        @click="showPdfPreview(uploadRecord.file_path)"
                        class="inline-flex items-center px-4 py-2 text-white bg-green-500 hover:bg-green-700 rounded transition-colors"
                      >
                        Preview
                      </button>
                      <span v-else class="text-gray-500">No file</span>
                    </div>
                  </div>
                </td>
                <td class="px-2 py-4">
                  <a
                    v-if="uploadRecord.youtube_link"
                    :href="uploadRecord.youtube_link"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-blue-500 hover:underline"
                  >
                    Watch on YouTube
                  </a>
                  <span v-else class="text-gray-500">N/A</span>
                </td>
              </tr>
            </template>
          </tbody>
        </table>
        <div class="col-span-12 mt-4">
          <Pagination
            :currentPage="currentPage"
            :totalPages="totalPages"
            @page-changed="fetchData"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, watch } from "vue";
import { useQuery } from "@vue/apollo-composable";
import Header from "@/components/header/Main.vue";
import Pagination from "@/components/pagination/Main.vue";
import { UPLOADRECORDS_QUERY } from "@/graphql/Queries/uploadRecords.graphql";

// Environment configuration - Make sure this matches your Laravel backend URL
const baseUrl = import.meta.env.VITE_API_URL || "https://holyfamilymedia.org/laravel/public/graphql";

// Reactive state
const uploadRecords = ref([]);
const currentPage = ref(1);
const totalPages = ref(1);
const filters = reactive({
  page: 1,
  first: 10,
  search: "",
});

// Apollo GraphQL Query
const {
  loading: uploadRecordsLoading,
  result: uploadRecordsResults,
  onResult,
  onError,
  refetch,
} = useQuery(
  UPLOADRECORDS_QUERY,
  () => ({
    page: currentPage.value,
    first: filters.first,
    search: filters.search,
  }),
  { fetchPolicy: "network-only" }
);

// Watchers
watch(currentPage, (newPage) => {
  refetch({ page: newPage, first: filters.first });
});

const debouncedFetchData = debounce(() => {
  refetch({ search: filters.search });
}, 300);

// Helper functions
const getFileName = (path) => {
  if (!path) return "No file";
  return path.split("/").pop() || "file";
};

// Get proper URL for audio files
const getAudioUrl = (path) => {
  if (!path) return "";
  
  // If it's already a full URL, return as is
  if (path.startsWith("http") || path.startsWith("data:")) {
    return path;
  }
  
  // Remove 'storage/' prefix if it exists
  const cleanPath = path.replace(/^storage\//, '');
  
  // Construct proper URL
  return `${baseUrl}/storage/${cleanPath}`;
};

// Get proper URL for files (PDFs)
const getFileUrl = (path) => {
  if (!path) return "";
  
  // If it's already a full URL, return as is
  if (path.startsWith("http") || path.startsWith("data:")) {
    return path;
  }
  
  // Remove 'storage/' prefix if it exists
  const cleanPath = path.replace(/^storage\//, '');
  
  // Construct proper URL
  const url = `${baseUrl}/storage/${cleanPath}`;
  
  console.log("File URL constructed:", {
    original: path,
    cleaned: cleanPath,
    finalUrl: url
  });
  
  return url;
};

const showPdfPreview = (path) => {
  const fullUrl = getFileUrl(path);
  if (fullUrl) {
    console.log("Opening PDF preview:", fullUrl);
    window.open(fullUrl, "_blank", "noopener,noreferrer");
  }
};

// Test if a URL is accessible
const testUrlAccess = async (url) => {
  try {
    const response = await fetch(url, { method: 'HEAD' });
    console.log(`URL ${url} accessible:`, response.ok);
    return response.ok;
  } catch (error) {
    console.error(`URL ${url} not accessible:`, error);
    return false;
  }
};

// Debounce utility
function debounce(fn, delay) {
  let timeoutId;
  return function (...args) {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => fn.apply(this, args), delay);
  };
}

// Handle query results
onResult((result) => {
  console.log("UploadRecords Query Result:", result);
  
  if (result.data?.uploadRecord?.data) {
    uploadRecords.value = result.data.uploadRecord.data;
    totalPages.value = result.data.uploadRecord.paginatorInfo.lastPage || 1;
    
    // Debug: Check file URLs
    uploadRecords.value.forEach((record, index) => {
      console.log(`Record ${index + 1}:`, {
        music_title: record.music_title,
        audio_path: record.audio_path,
        audio_url: getAudioUrl(record.audio_path),
        file_path: record.file_path,
        file_url: getFileUrl(record.file_path),
      });
      
      // Test URLs (optional)
      if (record.audio_path) {
        testUrlAccess(getAudioUrl(record.audio_path));
      }
      if (record.file_path) {
        testUrlAccess(getFileUrl(record.file_path));
      }
    });
  } else {
    console.log("No data returned from query", result);
    uploadRecords.value = [];
    totalPages.value = 1;
  }
});

onError((error) => {
  console.error("GraphQL Error:", error);
  uploadRecords.value = [];
});

// Fetch function for pagination
const fetchData = (page = 1) => {
  currentPage.value = page;
};
</script>

<style scoped>
table {
  border-collapse: separate;
  border-spacing: 0;
}

th,
td {
  padding: 12px 15px;
  background-color: rgba(219, 234, 254, 0.3);
}

th {
  background-color: #cbd5e1;
}

tr:hover td {
  background-color: rgba(191, 219, 254, 0.3);
}

/* Audio player styling */
audio {
  max-width: 100%;
  outline: none;
}

audio::-webkit-media-controls-panel {
  background-color: #3b82f6;
}

audio::-webkit-media-controls-play-button,
audio::-webkit-media-controls-mute-button {
  filter: invert(1);
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .filters {
    flex-direction: column;
    gap: 1rem;
  }
  
  .form-group {
    width: 100%;
  }
  
  table {
    display: block;
    overflow-x: auto;
    white-space: nowrap;
  }
  
  audio {
    width: 100%;
  }
}
</style>