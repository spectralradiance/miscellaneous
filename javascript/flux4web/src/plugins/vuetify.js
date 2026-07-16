import Vue from "vue";
import Vuetify from "vuetify/lib/framework";
import colors from "vuetify/lib/util/colors";
import "material-design-icons-iconfont/dist/material-design-icons.css";

Vue.use(Vuetify);

export default new Vuetify({
  icons: {
    iconfont: "md",
  },
  theme: {
    themes: {
      light: {
        primary: colors.green.base,
        secondary: colors.red.lighten4,
        accent: colors.indigo.base,
        navbar: colors.green.base,
        info: "#ffffff",
      },
      dark: {
        primary: colors.grey.darken3,
        secondary: colors.red.lighten4,
        accent: colors.indigo.base,
        navbar: colors.blueGrey.darken4,
        info: colors.grey.darken4,
      },
    },
    dark: false,
  },
});
