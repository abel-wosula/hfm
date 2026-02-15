import gql from "graphql-tag";

const HOMEPAGE_SECTION_QUERY = gql`
  query homepageSection($page: Int!, $first: Int!) {
    homepage_section(page: $page, first: $first) {
       data {
        key
        type
        title
        subtitle
        button_text
        button_secondary_text
        content
        button_link
        button_secondary_link
        is_active
        background_color
        text_align
        order
      }
      paginatorInfo {
        currentPage
        lastPage
        total
      }
    }
  }
`;

export { HOMEPAGE_SECTION_QUERY };
