<template>
  <v-container fluid class="resources">
    <v-row>
      <h1>Resources</h1>
    </v-row>
    <v-row>
      <v-col
        class="filter_column"
      >
        <v-btn-toggle
          v-model="selected_resource_type"
          tile
          >
          <v-btn
            v-for="(resource_type, index) in resource_types"
            :key="index"
            :value="resource_type"
            small
            
            class="primary">
            {{ resource_type }}
          </v-btn>
        </v-btn-toggle>
      </v-col>
    </v-row>
    <v-row>
      <v-expansion-panels>
        <v-expansion-panel v-for="(resource,i) in filteredResources" :key="i">
          <v-expansion-panel-header>
            <div>
              <h2>{{resource.name}}</h2>
              <h4 class="resource_author">
                <span>{{resource.type | capitalize}}</span>
                <span v-if="resource.author"> / {{resource.author}}</span>
              </h4>
            </div>
            <div class="link_container">
            <a :href="resource.url" target="_blank">&nbsp;<v-icon @click.native.stop color="primary">mdi-link-variant</v-icon></a>
            </div>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <div v-html="resource.description"></div>
            <span><a v-for="(url,j) in resource.urls" :key="j" :href="url" class="group_link" target="_blank"><v-icon>{{findIconForUrl(url)}}</v-icon></a></span>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </v-row>
  </v-container>
</template>
<style>
.resources h1 {
  margin: 10px 0;
}
.resources {
  max-width:800px;
  margin: 0 auto;
}
.resource_author {
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
  name: "Resources",
  data: () => ({
    resource_types: ['app', 'article', 'book', 'documentary', 'film', 'video', 'website'], // 'business', 'restaurant'],
    selected_resource_type: null,
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
    getResources() {
      this.$store.dispatch('getResources');
    }
  },
  computed: {
      filteredResources: function() {
        let resources = this.$store.state.resources
        resources = resources.slice()
        resources = resources.filter(e => {
          return e.submission_status == 'approved'
        })
        if (this.selected_resource_type != null) {
          resources = resources.filter(e => {
            return e.type == this.selected_resource_type
          })
        }
        resources.sort((a, b) => {
          return a.name.localeCompare(b.name)
        })
        return resources
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
    this.getResources()
  }
};
</script>
