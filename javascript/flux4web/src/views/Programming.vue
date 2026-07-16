<template>
  <v-container>
    <v-row no-gutters v-for="(item, index) in menu" :key="index">
      <v-col md="6" offset-md="3">
        <v-btn color="primary" class="mb-1" block :href="item.url">
          {{ item.name }}
        </v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "Menu",
  data: function () {
    return {
      menu: [],
      main_menu: [
        {
          name: "Codepen",
          url: "https://codepen.io/flux4",
        },
        {
          name: "Github",
          url: "https://github.com/flux4",
        },
        {
          name: "Veganism",
          url: null,
          menu: [
            {
              name: "Calculator",
              url: "/programming/vegan/calculator",
            },
            {
              name: "Resources",
              url: "/programming/vegan/resources",
            },
            {
              name: "Vemoji",
              url: "/programming/vegan/vemoji",
            },
          ],
        },
      ],
    };
  },
  created: function () {
    this.menu = this.main_menu;
  },
};
</script>
