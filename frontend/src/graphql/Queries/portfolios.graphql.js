import gql from "graphql-tag";

const PORTFOLIOS_QUERY = gql`
  query portfolios($page: Int!, $first: Int!) {
    portfolios(page: $page, first: $first) {
      data {
        title
        description
        yt_link
        thumbnail
      }
      paginatorInfo {
        currentPage
        lastPage
        total
      }
    }
  }
`;

export { PORTFOLIOS_QUERY };
