import gql from "graphql-tag";

const ADMIN_STATS_QUERY = gql`
  query uploads {
    music {
      data {
        music_title
        audio
        composer
        yt_link
        score
      }
      paginatorInfo {
        currentPage
        lastPage
        total
      }
    }
  }
`;

export { ADMIN_STATS_QUERY };
