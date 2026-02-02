<template>
  <div class="pagination">
    <button :disabled="currentPage === 1" @click="changePage(currentPage - 1)">
      Previous
    </button>

    <button
      v-for="page in totalPages"
      :key="page"
      :class="{ active: page === currentPage }"
      @click="changePage(page)"
    >
      {{ page }}
    </button>

    <button
      :disabled="currentPage === totalPages"
      @click="changePage(currentPage + 1)"
    >
      Next
    </button>
  </div>
</template>

<script>
export default {
  props: {
    currentPage: {
      type: Number,
      required: true,
    },
    totalPages: {
      type: Number,
      required: true,
    },
  },
  methods: {
    changePage(page) {
      this.$emit("page-changed", page);
    },
  },
};
</script>

<style scoped>
.pagination {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}
button {
  margin: 0 5px;
  padding: 5px 10px;
}
button.active {
  font-weight: bold;
  background-color: #007bff;
  color: white;
}
button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>
