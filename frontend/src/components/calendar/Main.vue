<template>
  <div>
    <!-- Year View Calendar -->
    <v-calendar
      is-expanded
      :attributes="attributes"
      :rows="3"
      :columns="4"
      @dayclick="onDayClick"
    />
  </div>
</template>

<script>
import { Calendar } from "v-calendar";
import "v-calendar/dist/style.css"; // Import the styles

export default {
  components: {
    VCalendar: Calendar, // Register the component
  },
  data() {
    return {
      // Attributes for calendar events
      attributes: [
        {
          key: "event1",
          highlight: "blue",
          dates: new Date(2025, 9, 1), // October 1, 2023
          popover: {
            label: "Event 1",
          },
        },
        {
          key: "event2",
          highlight: "green",
          dates: new Date(2025, 9, 15), // October 15, 2023
          popover: {
            label: "Event 2",
          },
        },
      ],
    };
  },
  methods: {
    onDayClick(day) {
      alert(`You clicked on ${day.date}`);
    },
  },
};
</script>

<style scoped>
/* Optional: Add custom styles for the calendar */
.vc-container {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
}
</style>
