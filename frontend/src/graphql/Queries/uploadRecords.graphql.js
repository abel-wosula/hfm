import gql from "graphql-tag";

const UPLOADRECORDS_QUERY = gql`
  query UploadRecords($page: Int!, $first: Int!) {
    uploadRecord(page: $page, first: $first) {
      data {
        id
        music_title
        audio_path
        file_path
        composer
        youtube_link
      }
      paginatorInfo {
        lastPage
      }
    }
  }
`;

export { UPLOADRECORDS_QUERY };
