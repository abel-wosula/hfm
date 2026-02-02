<!-- src/views/AdminLogin.vue -->
<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="max-w-md w-full space-y-8 p-8 bg-blue-100 rounded-lg shadow">
      <img
        src="/home/abel/Documents/Projects/studio/frontend/src/assets/logo.png"
        class="h-20 mx-auto"
        alt="HFM Logo"
      />
      <h2 class="text-center text-3xl font-bold text-gray-900">
        Admin Portal Login
      </h2>
      <form class="mt-8 space-y-6" @submit.prevent="handleLogin">
        <div>
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input
            v-model="form.email"
            type="email"
            required
            autocomplete="current-password"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700"
            >Password</label
          >
          <input
            v-model="form.password"
            type="password"
            required
            autocomplete="current-password"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          />
        </div>
        <button
          type="submit"
          :disabled="loading"
          class="w-full flex justify-center py-2 px-4 ..."
        >
          {{ loading ? "Logging in..." : "Sign in" }}
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useMutation } from "@vue/apollo-composable";
import { LOGIN_ADMIN_MUTATION } from "@/graphql/Mutations/loginAdmin.graphql";

const router = useRouter();
const form = ref({ email: "", password: "" });

const loading = ref(false);
const {
  mutate: loginAdmin,
  onDone,
  onError,
} = useMutation(LOGIN_ADMIN_MUTATION);

onDone(({ data }) => {
  localStorage.setItem("adminToken", data.loginAdmin.token);
  router.push("/admin/dashboard");
});

onError((error) => {
  console.error("Login failed:", error.message);
});

const handleLogin = async () => {
  try {
    if (!form.value.email || !form.value.password) {
      alert("Please fill all fields");
      return;
    }

    console.log("Sending Variables:", {
      email: form.value.email,
      password: form.value.password,
    });

    loading.value = true;

    const response = await loginAdmin({
      email: form.value.email,
      password: form.value.password,
    });

    console.log("Mutation Response:", response);

    if (!response || !response.data || !response.data.loginAdmin) {
      console.error("No response data", response);
      alert("Login failed. Please try again.");
      return;
    }

    const { token, user } = response.data.loginAdmin;

    if (!token || !user) {
      console.error("Invalid credentials", response);
      alert("Invalid credentials, please try again.");
      return;
    }

    console.log("✅ Login successful:", user);
    localStorage.setItem("token", token);
    router.push("/admin/dashboard");
  } catch (error) {
    console.error("Login error:", error);
    alert("Login failed. Check your credentials and try again.");
  } finally {
    loading.value = false;
  }
};
</script>
