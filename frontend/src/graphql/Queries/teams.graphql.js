import gql from "graphql-tag";

const TEAMS_QUERY = gql`
  query teams {
    team {
      data {
        title
        thumbnail
        first_name
        last_name
      }
      paginatorInfo {
        currentPage
        lastPage
        total
      }
    }
  }
`;

export { TEAMS_QUERY };
