<template>
  <Header activeLink="events" />
  <div
    class="max-w-7xl mx-auto px-4 py-8 min-h-screen flex flex-col lg:flex-row"
  >
    <!-- Left Side: Calendar -->
    <div class="w-full lg:w-1/3 bg-gray-100 p-4 rounded-lg shadow">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Event Calendar</h3>
      <Calendar />
    </div>

    <!-- Right Side: Events List -->
    <div class="w-full lg:w-2/3 p-4">
      <h3 class="text-2xl font-bold text-gray-900 mb-4">Upcoming Events</h3>
      <p v-if="loading" class="text-gray-500">Loading events...</p>
      <p v-if="error" class="text-red-500">Error loading events.</p>
      <div v-if="events.length === 0 && !loading" class="text-gray-500">
        No events available.
      </div>

      <div
        v-for="event in events"
        :key="event.id"
        class="bg-white shadow-md rounded-lg p-4 mb-4"
      >
        <h4 class="text-xl font-bold text-gray-800">{{ event.title }}</h4>
        <p class="text-gray-600 text-sm">📍 {{ event.location }}</p>
        <p class="text-gray-500 text-sm">
          📅 {{ formatDate(event.updated_at) }}
        </p>
        <p class="text-gray-700 mt-2">{{ event.description }}</p>
      </div>
    </div>
  </div>

  <Footer />
</template>

<script>
import { ref, onMounted } from "vue";
import { useQuery } from "@vue/apollo-composable";
import gql from "graphql-tag";
import Calendar from "@/components/calendar/Main.vue";
import Header from "@/components/header/Main.vue";
import Footer from "@/components/footer/Main.vue";

const EVENTSQUERY = gql`
  query {
    events {
      id
      title
      location
      updated_at
      description
    }
  }
`;

export default {
  components: { Calendar, Header, Footer },
  setup() {
    const { result, loading, error } = useQuery(EVENTSQUERY);
    const events = ref([]);

    onMounted(() => {
      if (result.value) {
        events.value = result.value.events;
      }
    });

    const formatDate = (dateString) => {
      return new Date(dateString).toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
      });
    };

    return { events, loading, error, formatDate };
  },
};
</script>
