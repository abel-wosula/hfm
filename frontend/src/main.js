import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";

import { provideApolloClient } from "@vue/apollo-composable";
import { apolloClient } from "./apollo.default_client.config";
provideApolloClient(apolloClient);
const app = createApp(App);

app.use(router);

app.mount("#app");
