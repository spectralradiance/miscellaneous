<template>
  <v-app>


    <v-navigation-drawer
      v-model="drawer"
      disable-resize-watcher
      app
      right
      clipped
    >
      <v-list>
        <v-list-item link to="/">
          <v-list-item-action>
            <v-icon>mdi-home</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Home</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item
          link
          v-for="(item, index) in menu"
          :key="index"
          :to="item.path"
        >
          <v-list-item-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>{{ item.text }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item link>
          <v-list-item-action>
            <v-icon>mdi-invert-colors</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Switch Theme</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app clipped-right dense color="primary" class="white--text">
      <v-toolbar-title
        ><span
          style="
            display: inline-block;
            transform: translateY(-2px);
            font-size: 28px;
            margin-right: 10px;
            cursor: pointer;
            user-select: none;
          "
          @click="toggleTheme"
          >φ</span
        >
        <span style="cursor: pointer" @click="$router.push('/')">flux4</span>
      </v-toolbar-title>
      <v-spacer />

      <!-- tabs -->
      <v-sheet class="hidden-sm-and-down" color="primary">
        <v-tabs
          next-icon="mdi-arrow-right-bold-box-outline"
          prev-icon="mdi-arrow-left-bold-box-outline"
          show-arrows
          background-color="transparent"
        >
          <v-tabs-slider color="white"></v-tabs-slider>
          <v-tab
            v-for="(item, index) in menu"
            :key="index"
            :to="item.path"
            class="white--text text-subtitle-1 text-lowercase"
            background-color="transparent"
          >
            {{ item.text }}
          </v-tab>
        </v-tabs>
      </v-sheet>

      <v-app-bar-nav-icon
        class="white--text hidden-md-and-up"
        @click.stop="drawer = !drawer"
      />
    </v-app-bar>

    <v-main>
      <transition name="fade" mode="out-in">
        <router-view :key="$route.path" />
      </transition>
    </v-main>
  </v-app>
</template>
<style>
.fade-enter-active,
.fade-leave-active {
  transition-duration: 0.1s;
  transition-property: opacity;
  transition-timing-function: ease;
}

.fade-enter,
.fade-leave-active {
  opacity: 0;
}
</style>
<script>
export default {
  name: "App",

  data: () => ({
    drawer: false,
    menu: [
      // {
      //   icon: "mdi-pencil",
      //   text: "writing",
      //   path: "/writing/",
      // },
      {
        icon: "mdi-code-braces",
        text: "programming",
        path: "/programming/",
      },
      {
        icon: "mdi-camera",
        text: "photography",
        path: "/photography/",
      },
      {
        icon: "mdi-lightbulb",
        text: "inspiration",
        path: "/inspiration/",
      },
    ],
  }),
  methods: {
    randomElement: function (arr) {
      return arr[Math.floor(Math.random() * arr.length)];
    },
    toggleTheme: function () {
      this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
      // dark_primary = ['#A05', '#80F', ]
      let dark_primary = ["#D81B60", "#4A148C", "#311B92", "#1A237E"];
      let light_primary = [
        "#FF8F00",
        "#4CAF50",
        "#26A69A",
        "#26C6DA",
        "#E53935",
      ];
      if (this.$vuetify.theme.dark) {
        this.$vuetify.theme.themes.dark.primary =
          this.randomElement(dark_primary);
      } else {
        this.$vuetify.theme.themes.light.primary =
          this.randomElement(light_primary);
      }
      // this.$vuetify.theme.primary = '#A05'
      // console.log(this.$vuetify.theme)
    },
  },
};
</script>
