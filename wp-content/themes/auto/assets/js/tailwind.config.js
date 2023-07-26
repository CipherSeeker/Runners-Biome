tailwind.config = {
  theme: {
    screens: {
      sm: { max: "479px" },
      md: { max: "767px" },
      lg: { max: "1295px" },
      xl: { min: "1296px" },
    },
    container: {
      center: true,
      padding: "1rem",

      // screens: {
      //   sm: "320px", w: "100%",
      //   md: "480px", w: "480px",
      //   lg: "768px", w: "768px",
      //   xl: "1200px", w: "1296px",
      // },
    },

    colors: {
      primary: "#00AAA1",
      secondary: "#E8F3F3",
      tertiary: "#F2F8F7",
      textHeader: "#333333",
      textTitles: "#222222",
      textPosts: "#555555",
      textTags: "#666666",
      textUnderPosts: "#777777",
      categoriesText: "#1C1C1C",
      transparent: "transparent",
    },
  },
};
