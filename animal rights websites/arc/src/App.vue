<template>
  <v-app id="inspire" :dark="goDark">
    <v-navigation-drawer
      v-model="drawer"
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

        <v-list-item link to="/events">
          <v-list-item-action>
            <v-icon>mdi-calendar</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Events</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item link to="/organizations">
          <v-list-item-action>
            <v-icon>mdi-rhombus-split</v-icon>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>Organizations</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item link to="/communities">
          <v-list-item-action>
            <v-icon>mdi-account-group</v-icon>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>Communities</v-list-item-title>
          </v-list-item-content>
        </v-list-item>


        <v-list-item link to="/sanctuaries">
          <v-list-item-action>
            <v-icon>mdi-barn</v-icon>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>Sanctuaries</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <!-- <v-list-item link to="/articles">
          <v-list-item-action>
            <v-icon>mdi-text-box-outline</v-icon>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>Articles</v-list-item-title>
          </v-list-item-content>
        </v-list-item> -->

        <v-list-item link to="/resources">
          <v-list-item-action>
            <v-icon>mdi-vector-link</v-icon>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>Resources</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item link to="/calculator">
          <v-list-item-action>
            <v-icon>mdi-calculator</v-icon>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>Calculator</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        
        <v-list-item link to="/emojis">
          <v-list-item-action>
            <v-icon>mdi-emoticon</v-icon>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>Emojis</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item link to="/about">
          <v-list-item-action>
            <v-icon>mdi-information-outline</v-icon>
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>About</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item link @click="toggleTheme">
          <v-list-item-action>
            <v-icon>mdi-invert-colors</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title >Switch Theme</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar
      app
      dense
      clipped-right
      color="navbar"
      class="white--text"
    >
      <div class="title_large">
      <v-btn icon>
        <v-icon class="white--text">mdi-blank</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon class="white--text">mdi-blank</v-icon>
      </v-btn>
      </div>
      <v-spacer />
      <div class="title_large">
        
        <v-toolbar-title>
          <span @click="randomTitleSymbol">{{ title_symbol }}</span>
          <span>&nbsp;Animal Rights Collective Portland&nbsp;</span>
          <span @click="randomTitleSymbol">{{ title_symbol }}</span>
        </v-toolbar-title>
      </div>
      <div class="title_small">
        <v-toolbar-title>
          <span @click="randomTitleSymbol">{{ title_symbol }}</span>
          <span>&nbsp;ARCPDX&nbsp;</span>
          <span @click="randomTitleSymbol">{{ title_symbol }}</span>
        </v-toolbar-title>
      </div>
      <v-spacer />
      <!-- <v-btn icon>
        <v-icon class="white--text">mdi-magnify</v-icon>
      </v-btn> -->
      <v-app-bar-nav-icon class="white--text" @click.stop="drawer = !drawer" />
    </v-app-bar>

    <v-content>
      <transition
        name="fade"
        mode="out-in"
      >
      <router-view :key="$route.path"/>
      </transition>
    </v-content>


  </v-app>
</template>
<style>
  #inspire {
    font-family: 'Open Sans', sans-serif;

  }
  .v-toolbar__title {
    font-size:2rem !important;
    cursor:pointer;
    user-select:none;
  }
  .title_small {
    display:none;
  }
  @media (max-width: 800px) {
    .title_small {
      display:block;
    }
    .title_large {
      display:none;
    }
  }
  a {
    text-decoration: none;
    /* color: lightgoldenrodyellow !important; */
  }
  .fade-enter-active,
  .fade-leave-active {
    transition-duration: 0.1s;
    transition-property: opacity;
    transition-timing-function: ease;
  }

  .fade-enter,
  .fade-leave-active {
    opacity: 0
  }
</style>
<script>

  export default {
    name: 'Home',
    props: {
      source: String,
    },
    data: () => ({
      drawer: null,
      goDark: false,
      title_symbol: '',
      symbols: {
        // 'leaf_left': '☙',
        // 'flower': '⚘',
        'seedling': '🌱',
        'evergreen_tree': '🌲',
        'deciduous_tree': '🌳',
        'palm_tree': '🌴',
        'cactus': '🌵',
        // 'tulip': '🌷',
        // 'cherry_blossom': '🌸',
        'rose': '🌹',
        // 'hibiscus': '🌺',
        'sunflower': '🌻',
        'blossom': '🌼',
        'herb': '🌿',
        'four_leaf_clover': '🍀',
        'maple_leaf': '🍁',
        'fallen_leaf': '🍂',
        // //'leaf_fluttering_in_wind': '🍃',
        // 'tomato': '🍅',
        // 'aubergine': '🍆',
        // 'grapes': '🍇',
        // 'melon': '🍈',
        // 'watermelon': '🍉',
        // 'tangerine': '🍊',
        // 'lemon': '🍋',
        // 'banana': '🍌',
        // 'pineapple': '🍍',
        // 'red_apple': '🍎',
        // 'green_apple': '🍏',
        // 'pear': '🍐',
        // 'peach': '🍑',
        // 'cherries': '🍒',
        // 'strawberry': '🍓',
        // //'boquet': '💐',
        // 'white_flower': '💮',

        // 'white chess knight': '♘',
        // 'black chess knight': '♞',
        'rat': '🐀',
        'mouse': '🐁',
        'ox': '🐂',
        'water buffalo': '🐃',
        'cow': '🐄',
        'tiger': '🐅',
        'leopard': '🐆',
        'rabbit': '🐇',
        'cat': '🐈',
        //'dragon': '🐉',
        'crocodile': '🐊',
        'whale': '🐋',
        'snail': '🐌',
        'snake': '🐍',
        'horse': '🐎',
        'ram': '🐏',
        'goat': '🐐',
        'sheep': '🐑',
        'monkey': '🐒',
        'rooster': '🐓',
        'chicken': '🐔',
        'dog': '🐕',
        'pig': '🐖',
        'boar': '🐗',
        'elephant': '🐘',
        'octopus': '🐙',
        'spiral shell': '🐚',
        'bug': '🐛',
        'ant': '🐜',
        'honeybee': '🐝',
        'lady beetle': '🐞',
        'fish': '🐟',
        'tropical fish': '🐠',
        'blowfish': '🐡',
        'turtle': '🐢',
        'hatching chick': '🐣',
        'baby chick': '🐤',
        'front-facing baby chick': '🐥',
        'bird': '🐦',
        'penguin': '🐧',
        'koala': '🐨',
        'poodle': '🐩',
        'dromedary camel': '🐪',
        'bactrian camel': '🐫',
        'dolphin': '🐬',
        'mouse face': '🐭',
        'cow face': '🐮',
        'tiger face': '🐯',
        'rabbit face': '🐰',
        'cat face': '🐱',
        //'dragon face': '🐲',
        'spouting whale': '🐳',
        'horse face': '🐴',
        'monkey face': '🐵',
        'dog face': '🐶',
        'pig face': '🐷',
        'frog face': '🐸',
        'hamster face': '🐹',
        'wolf face': '🐺',
        'bear face': '🐻',
        'panda face': '🐼',
        'pig nose': '🐽',
        'paw prints': '🐾',
        //'grinning cat face with smiling eyes': '😸',
        //'cat face with tears of joy': '😹',
        //'smiling cat face with open mouth': '😺',
        //'smiling cat face with heart-shaped eyes': '😻',
        //'cat face with wry smile': '😼',
        //'kissing cat face with closed eyes': '😽',
        //'pouting cat face': '😾',
        //'crying cat face': '😿',
        //'weary cat face': '🙀',
        'see-no-evil monkey': '🙈',
        'speak-no-evil monkey': '🙊',
        'hear-no-evil monkey': '🙉',
        'globe-showing-americas': '🌎',
        'globe-showing-europe-africa': '🌍',
        'globe-showing-asia-australia': '🌏'
      }
    }),
    methods: {
      toggleTheme: function() {
        if (this.goDark == true) {
          this.goDark = false
          this.$vuetify.theme.dark = false
        } else {
          this.goDark = true
          this.$vuetify.theme.dark = true
        }
      },
      randomTitleSymbol: function() {
        let keys = Object.keys(this.symbols)
        this.title_symbol = this.symbols[keys[Math.floor(keys.length * Math.random())]];
      }
    },
    created: function() {
      this.randomTitleSymbol()
    }
  }
</script>