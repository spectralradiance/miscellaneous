<template>
  <v-container>
    <CoolLightBox
      :items="items"
      :index="index"
      @close="index = null"
      :fullScreen="true"
    >
    </CoolLightBox>
    <v-row class="mt-2">
      <v-col>
        <span
          class="primary--text mr-5"
          :class="'text-h' + (index + 3)"
          style="cursor: pointer"
          v-for="(breadcrumb, index) in breadcrumbs"
          :key="index"
          @click="
            loadFolder(breadcrumb);
            breadcrumbs.splice(0, index + 1);
          "
        >
          <span class="mr-x13">{{ breadcrumb.name }}</span>
        </span>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-btn
          v-for="(folder, index) in folders"
          :key="index"
          class="mr-3"
          color="primary"
          @click="loadFolder(folder)"
          >{{ folder.name }}</v-btn
        >
      </v-col>
    </v-row>
    <v-row>
      <v-col
        v-for="(file, n) in files"
        :key="n"
        class="d-flex child-flex"
        cols="4"
      >
        <v-img
          :src="file.url"
          referrerpolicy="no-referrer"
          :lazy-src="file.url"
          aspect-ratio="1"
          class="grey lighten-2 elevation-4"
          @click="index = n"
        >
          <template v-slot:placeholder>
            <v-row class="fill-height ma-0" align="center" justify="center">
              <v-progress-circular
                indeterminate
                color="grey lighten-5"
              ></v-progress-circular>
            </v-row>
          </template>
        </v-img>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axios from "axios";
import CoolLightBox from "vue-cool-lightbox";
import "vue-cool-lightbox/dist/vue-cool-lightbox.min.css";

export default {
  name: "Photography",

  data: () => ({
    photo_folder: {
      name: "All Photos",
      id: "????",
    },
    breadcrumbs: [],
    current_folder: { name: "", id: "" },
    folders: [],
    files: [],
    drive_api_key: "????",
    items: [],
    index: null,
  }),

  methods: {
    loadFolder(folder) {
      axios({
        method: "get",
        url: "https://www.googleapis.com/drive/v3/files",
        params: {
          q: "'" + folder.id + "' in parents",
          key: this.drive_api_key,
          fields: "files(id,name,description,mimeType,imageMediaMetadata)",
        },
      }).then((response) => {
        console.log(response.data);
        this.current_folder = folder;
        this.breadcrumbs.unshift(folder);
        this.folders = [];
        this.files = [];
        this.items = [];
        for (let d of response.data.files) {
          if (d.mimeType == "application/vnd.google-apps.folder") {
            this.folders.push({
              id: d.id,
              name: d.name,
            });
          } else {
            let shutter_speed = d.imageMediaMetadata.exposureTime;
            shutter_speed =
              (shutter_speed >= 0.5
                ? shutter_speed
                : "1/" + Math.round(1 / shutter_speed)) + "s";
            let url = "https://drive.google.com/uc?id=" + d.id;
            console.log(url);
            let file = {
              id: d.id,
              name: d.name,
              camera:
                d.imageMediaMetadata.cameraMake +
                " " +
                d.imageMediaMetadata.cameraModel,
              lens: d.imageMediaMetadata.lens,
              aperture: "f/" + d.imageMediaMetadata.aperture,
              focal_length: d.imageMediaMetadata.focalLength + "mm",
              iso: d.imageMediaMetadata.isoSpeed,
              shutter_speed: shutter_speed,
              date_taken: d.imageMediaMetadata.time,
              url: url,
            };
            this.files.push(file);
            this.items.push({
              title: d.description,
              // TODO: find a more elegant solution
              description:
                '<span style="white-space:nowrap">&nbsp;&nbsp;<i aria-hidden="true" class="v-icon notranslate mdi mdi-camera theme--dark"></i>&nbsp;' +
                file.camera +
                "</span>" +
                '&nbsp;&nbsp;<span style="white-space:nowrap"><i aria-hidden="true" class="v-icon notranslate mdi mdi-circle-double theme--dark"></i>&nbsp;' +
                file.lens +
                "</span>" +
                "<br/>" +
                '&nbsp;&nbsp;<span style="white-space:nowrap"><i aria-hidden="true" class="v-icon notranslate mdi mdi-camera-iris theme--dark"></i>&nbsp;' +
                file.aperture +
                "</span>" +
                '&nbsp;&nbsp;<span style="white-space:nowrap"><i aria-hidden="true" class="v-icon notranslate mdi mdi-timer-outline theme--dark"></i>&nbsp;' +
                file.shutter_speed +
                "</span>" +
                '&nbsp;&nbsp;<span style="white-space:nowrap"><i aria-hidden="true" class="v-icon notranslate mdi mdi-ruler theme--dark"></i>&nbsp;' +
                file.focal_length +
                "</span>" +
                '&nbsp;&nbsp;<span style="white-space:nowrap"><i aria-hidden="true" class="v-icon notranslate mdi mdi-grid theme--dark"></i>&nbsp;' +
                file.iso +
                "</span>",
              src: url,
              date_taken: file.date_taken,
            });
          }
        }
        this.folders.sort((a, b) => a.name.localeCompare(b.name));
        this.files.sort((a, b) => a.date_taken.localeCompare(b.date_taken));
        this.items.sort((a, b) => a.date_taken.localeCompare(b.date_taken));
        // console.log(this.folders);
        // console.log(this.files);
      });
    },
  },

  created: function () {
    this.loadFolder(this.photo_folder);
  },

  components: {
    CoolLightBox,
  },
};
</script>

<style scoped>
.image {
  width: 200px;
  height: 200px;
}
</style>
