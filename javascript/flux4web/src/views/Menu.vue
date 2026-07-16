<template>
  <v-container>
    <v-row>
      <v-col>
        <h1 class="text-center ma-5">{{ title }}</h1>
      </v-col>
    </v-row>
    <v-row no-gutters v-for="(item, index) in menu" :key="index">
      <v-col md="6" offset-md="3">
        <v-btn color="primary" class="mb-1" block :to="item.path">
          {{ item.name }}
        </v-btn>
      </v-col>
    </v-row>
    <router-view></router-view>
  </v-container>
</template>

<script>
export default {
  name: "Menu",
  data: function () {
    return {};
  },
  props: ['title', 'menu']
};
</script>
