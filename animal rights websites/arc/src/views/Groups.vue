<template>
  <v-container fluid class="groups">
    <v-row>
      <h1>{{ group_type.plural | capitalize }}</h1>
    </v-row>
    <v-row>
      <v-expansion-panels>
        <v-expansion-panel v-for="(group,i) in filteredGroups" :key="i">
          <v-expansion-panel-header>
            <div>
              <h2>{{group.name}}</h2>
            </div>
            <div class="link_container">
            <a :href="group.urls[0]" target="_blank">&nbsp;<v-icon @click.native.stop color="primary">mdi-link-variant</v-icon></a>
            </div>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <div>{{group.description}}</div>
            <div class="group_links">
              <span><a v-for="(url,j) in group.urls" :key="j" :href="url" class="group_link" target="_blank"><v-icon>{{findIconForUrl(url)}}</v-icon></a></span>
            </div>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </v-row>
  </v-container>
</template>
<style>
.groups h1 {
  margin: 10px 0;
}
.groups {
  max-width:800px;
  margin: 0 auto;
}
.group_author {
  margin-top:4px;
}
.v-btn-toggle {
  flex-wrap: wrap;
  justify-content: center;
  background-color:transparent !important;
}
.v-btn-toggle .v-btn {
  margin:2px;
}
.filter_column {
  padding: 12px 0 !important;
}
.v-btn-toggle .v-btn.theme--light:not(.v-btn--active) {
  background-color: transparent !important;
  border:1px solid grey;
}
.v-btn-toggle .v-btn.theme--dark:not(.v-btn--active) {
  background-color: transparent !important;
  border:1px solid grey;
}
.v-btn-toggle .v-btn.theme--light:not(.v-btn--active) .v-btn__content {
  color:black !important;
}

.v-btn-toggle .theme--light .v-btn__content {
  color: white;
}
.v-btn-toggle .v-btn--active.theme--light .v-btn__content {
  color:white;
}
.link_container {
  display:flex;
  flex-direction: row-reverse;
  align-items:center;
  padding-right:10px;
}

</style>
<script>
export default {
  name: "Groups",
  props: ['group_type'],
  data: () => ({
    group_types: ['organizations', 'communities', 'sanctuaries', 'restaurants', 'businesses'],
  }),
  methods: {
    findIconForUrl: function(url) {
      if (url.includes('facebook')) {
        return 'mdi-facebook'
      } else if (url.includes('instagram')) {
        return 'mdi-instagram'
      } else if (url.includes('twitter')) {
        return 'mdi-twitter'
      } else if (url.includes('youtube')) {
        return 'mdi-youtube'
      } else if (url.includes('meetup')) {
        return 'mdi-alpha-m'
      } else {
        return 'mdi-web'
      }
    },
    getGroups() {
      this.$store.dispatch('getGroups');
    }
  },
  computed: {
    filteredGroups: function() {
      let groups = this.$store.state.groups
      groups = groups.slice()
      groups = groups.filter(e => {
        return e.submission_status == 'approved'
      })
      if (this.group_type != null) {
        groups = groups.filter(e => {
          return e.type == this.group_type.singular
        })
      }
      groups.sort((a, b) => {
        return a.name.localeCompare(b.name)
      })
      return groups
    }
  },
  filters: {
    capitalize: function (value) {
      if (!value) return ''
      value = value.toString()
      return value.charAt(0).toUpperCase() + value.slice(1)
    }
  },
  mounted: function() {
    this.getGroups()
  }
};
</script>
