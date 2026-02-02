import gql from "graphql-tag";

const SERVICES_QUERY = gql`
  query services {
    services {
      data {
        id
        title
        description
        thumbnail
        short_description
        created_at
        updated_at
      }
      paginatorInfo {
        currentPage
        lastPage
        total
      }
    }
  }
`;

export { SERVICES_QUERY };
