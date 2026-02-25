import {
  ApolloClient,
  createHttpLink,
  InMemoryCache,
} from "@apollo/client/core";

// Use environment variable with fallback to localhost for development
const graphqlUrl = import.meta.env.VITE_API_BASE_URL 
  ? `${import.meta.env.VITE_API_BASE_URL}/graphql`
  : "http://127.0.0.1:8000/graphql";

// HTTP connection to the API
const httpLink = createHttpLink({
  uri: graphqlUrl,
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