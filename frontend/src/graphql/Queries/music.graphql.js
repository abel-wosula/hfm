import gql from "graphql-tag";

const MUSIC_QUERY = gql`
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

export { MUSIC_QUERY };
