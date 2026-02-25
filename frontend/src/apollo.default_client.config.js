import {
  ApolloClient,
  createHttpLink,
  InMemoryCache,
} from "@apollo/client/core";

// HTTP connection to the API
const httpLink = createHttpLink({
  uri: "http://127.0.0.1:8000/graphql",
  headers: {
    'X-Requested-With': 'XMLHttpRequest', // This tells Laravel it's an AJAX request
  },
  credentials: 'include',
});
// Cache implementation
const cache = new InMemoryCache();

// Create the apollo client
const apolloClient = new ApolloClient({
  link: httpLink,
  cache,
});

export { apolloClient };
