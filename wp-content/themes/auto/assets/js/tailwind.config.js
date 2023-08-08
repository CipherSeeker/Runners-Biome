tailwind.config = {
    theme: {
    screens: {
      sm: { max: "320px" },
      md: { max: "767px" },
      lg: { max: "1295px" },
      xl: { min: "1296px" },
    },
    container: {
      center: true,
      padding: "1rem",
    },
    colors: {
      primary: "#00AAA1",
      secondary: "#E8F3F3",
      tertiary: "#F2F8F7",
      textHeader: "#333333",
      textTitles: "#222222",
      textPosts: "#555555",
      textTags: "#666666",
      textAuthor:"#777777",
      textUnderPosts: "##595959",
      categoriesText: "#1C1C1C",
      transparent: "transparent",
    },
  },
  experimental: {
    optimizeUniversalDefaults: true,
  },
};
