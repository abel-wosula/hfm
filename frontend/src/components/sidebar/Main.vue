<template>
  <aside class="sidebar">
    <ul>
      <li><router-link to="/admin">Dashboard</router-link></li>
      <li><router-link to="/admin/content">Manage Content</router-link></li>
      <li><button @click="logout">Logout</button></li>
    </ul>
  </aside>
</template>

<script setup>
import { useRouter } from "vue-router";

const router = useRouter();
const logout = () => {
  localStorage.removeItem("token");
  router.push("/login");
};
</script>

<style scoped>
.sidebar {
  width: 250px;
  background: #333;
  color: white;
  padding: 20px;
}
.sidebar ul {
  list-style: none;
  padding: 0;
}
.sidebar li {
  margin-bottom: 10px;
}
</style>
