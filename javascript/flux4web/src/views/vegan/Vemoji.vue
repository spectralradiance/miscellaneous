<template>
  <v-container class="center">
    <div id="maindiv">
      <h1>Emojis</h1>
      <!-- <div class="row">
        <div class="input-field inline col s6">
          <v-select :items="tags" label="Tag"></v-select>
        </div>
        <div class="input-field inline col s2">
          <v-text-field v-model="generate_count" label="Emojis to Generate"></v-text-field>
        </div>
        <div class="input-field inline col s4">
          <v-btn class="primary" v-on:click="generateEmojis()">Generate</v-btn>
        </div>
      </div> -->
      <div id="rightdiv" class="info">
        <div id="textareacontainer">
          <v-textarea
            name="input-7-1"
            v-model="output"
            class="output"
          ></v-textarea>
        </div>
        <div id="buttondiv">
          <v-btn class="primary" v-on:click="backspace()" title="backspace">
            <v-icon>mdi-backspace</v-icon>
          </v-btn>

          <v-btn class="primary" v-on:click="shuffleOutput()" title="shuffle">
            <v-icon>mdi-sync</v-icon>
          </v-btn>

          <br />

          <v-btn class="primary" v-on:click="clearOutput()" title="clear">
            <v-icon>mdi-close</v-icon>
          </v-btn>

          <v-btn class="primary" v-on:click="copyOutput()" title="copy">
            <v-icon>mdi-content-copy</v-icon>
          </v-btn>
        </div>
      </div>

      <div id="leftdiv">
        <div
          class="tag_section"
          v-for="(tag, index) in tags"
          v-bind:key="index"
        >
          <div class="emoji_section_title">
            {{ capitalize(tag) }}
            <a v-on:click="randomEmoji(tag)">🎲</a>
          </div>
          <span
            class="clickable"
            v-for="(emoji, index_emoji) in getEmojis(tag)"
            v-bind:key="index_emoji"
            v-bind:title="capitalize(emoji.name)"
            v-on:click="emojiClicked(emoji)"
            >{{ emoji.symbol }}</span
          >
        </div>
      </div>
    </div>
  </v-container>
</template>
<style scoped>
h3 {
  padding: 0;
  margin: 10px;
}

#maindiv {
  margin: 0 auto;
  max-width: 600px;
  display: flex;
  flex-direction: column;
}

#leftdiv * {
  -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none; /* Safari */
  -khtml-user-select: none; /* Konqueror HTML */
  -moz-user-select: none; /* Firefox */
  -ms-user-select: none; /* Internet Explorer/Edge */
  user-select: none; /* Non-prefixed version, currently
                                    supported by Chrome and Opera */
}

#leftdiv {
  padding: 20px;
}

#rightdiv {
  position: sticky;
  left: 0;
  top: 40px;
  z-index: 1;
  /* background-color: var(--v-primary-color); */
  /* background-color: black; */
  /* background-color: var(--v-background) !important; */
  border-bottom: 4px solid #4caf50 !important;
  text-align: center;
  width: 100%;
  white-space: nowrap;
  vertical-align: middle;
  display: table;
}
/* #rightdiv:after {
  content: " ";
  border: 1px solid black;
} */

.clickable {
  cursor: pointer;
  font-size: 26px;
  border-radius: 4px;
  text-align: center;
  margin: 2px;
  transition: all ease 0.8s;
  width: 45px;
  height: 45px;
  display: inline-block;
}

.clickable:active {
  background-color: #4caf50;
}
.clickable:hover {
  background-color: #4caf50;
}

/* #textareacontainer {
  display: table-cell;
  padding: 0px 10px;
} */

.output {
  /*   height: 6rem !important; */
  font-size: 26px !important;
  /*width: auto !important;*/
}

#buttondiv {
  display: table-cell;
  height: 100%;
  vertical-align: middle;
}

#buttondiv button {
  margin: 4px;
}

.emoji_section_title {
  /*margin-top:30px;*/
  font-size: 30px;
}

.emoji_section_title a {
  font-size: 18px;
  border-radius: 4px;
  cursor: pointer;

  /* I tried so many things, this was the best
      I could come up with*/
  position: relative;
  top: -4px;
  left: 0;
  transition: all ease 0.8s;
}

.emoji_section_title a:hover {
  background-color: #4caf50;
}

.tag_section {
  margin-bottom: 40px;
}

.row {
  margin: 0 !important;
}

.row a {
  margin: 6px;
  width: 100%;
}
.input-field {
  margin: 0 !important;
}

#titlediv {
  display: flex;
  flex-direction: row;
}
#titlediv input {
  text-align: right;
  position: relative;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>
<script>
export default {
  name: "Calculator",
  data: () => ({
    symbols: [
      {
        name: "Globe Showing Europe-Africa",
        symbol: "🌍",
        tags: ["activism", "nature"],
      },
      {
        name: "Globe Showing Americas",
        symbol: "🌎",
        tags: ["activism", "nature"],
      },
      {
        name: "Globe Showing Asia-Australia",
        symbol: "🌏",
        tags: ["activism", "nature"],
      },
      { name: "Globe with Meridians", symbol: "🌐", tags: ["nature"] },
      { name: "New Moon", symbol: "🌑", tags: ["nature"] },
      { name: "Waxing Crescent Moon", symbol: "🌒", tags: ["nature"] },
      { name: "First Quarter Moon", symbol: "🌓", tags: ["nature"] },
      { name: "Waxing Gibbous Moon", symbol: "🌔", tags: ["nature"] },
      { name: "Full Moon", symbol: "🌕", tags: ["nature"] },
      { name: "Waning Gibbous Moon", symbol: "🌖", tags: ["nature"] },
      { name: "Last Quarter Moon", symbol: "🌗", tags: ["nature"] },
      { name: "Waning Crescent Moon", symbol: "🌘", tags: ["nature"] },
      { name: "Crescent Moon", symbol: "🌙", tags: ["nature"] },
      { name: "New Moon Face", symbol: "🌚", tags: ["nature"] },
      { name: "First Quarter Moon Face", symbol: "🌛", tags: ["nature"] },
      { name: "Last Quarter Moon Face", symbol: "🌜", tags: ["nature"] },
      { name: "Sun", symbol: "☀", tags: ["nature"] },
      { name: "Full Moon Face", symbol: "🌝", tags: ["nature"] },
      { name: "Sun with Face", symbol: "🌞", tags: ["nature"] },
      { name: "Star", symbol: "⭐", tags: ["nature"] },
      { name: "Glowing Star", symbol: "🌟", tags: ["nature"] },
      { name: "Shooting Star", symbol: "🌠", tags: ["nature"] },
      { name: "Cloud", symbol: "☁", tags: ["nature"] },
      { name: "Sun Behind Cloud", symbol: "⛅", tags: ["nature"] },
      { name: "Cloud with Lightning and Rain", symbol: "⛈", tags: ["nature"] },
      { name: "Sun Behind Small Cloud", symbol: "🌤", tags: ["nature"] },
      { name: "Sun Behind Large Cloud", symbol: "🌥", tags: ["nature"] },
      { name: "Sun Behind Rain Cloud", symbol: "🌦", tags: ["nature"] },
      { name: "Cloud with Rain", symbol: "🌧", tags: ["nature"] },
      { name: "Cloud with Snow", symbol: "🌨", tags: ["nature"] },
      { name: "Cloud with Lightning", symbol: "🌩", tags: ["nature"] },
      { name: "Tornado", symbol: "🌪", tags: ["nature"] },
      { name: "Fog", symbol: "🌫", tags: ["nature"] },
      { name: "water wave", symbol: "🌊", tags: ["nature"] },
      // { name: "comet", symbol: "☄", tags: ["nature"] },
      { name: "snowflake", symbol: "❄", tags: ["nature"] },

      { name: "seedling", symbol: "🌱", tags: ["plant", "nature"] },
      { name: "evergreen tree", symbol: "🌲", tags: ["plant", "nature"] },
      { name: "deciduous tree", symbol: "🌳", tags: ["plant", "nature"] },
      { name: "maple leaf", symbol: "🍁", tags: ["plant"] },
      { name: "fallen leaf", symbol: "🍂", tags: ["plant"] },
      { name: "palm tree", symbol: "🌴", tags: ["plant"] },
      { name: "cactus", symbol: "🌵", tags: ["plant"] },
      { name: "tulip", symbol: "🌷", tags: ["plant", "flower"] },
      { name: "cherry blossom", symbol: "🌸", tags: ["plant", "flower"] },
      { name: "rose", symbol: "🌹", tags: ["plant", "flower"] },
      { name: "hibiscus", symbol: "🌺", tags: ["plant", "flower"] },
      { name: "Sunflower", symbol: "🌻", tags: ["plant", "flower"] },
      { name: "Blossom", symbol: "🌼", tags: ["plant", "flower"] },
      { name: "Wilted Flower", symbol: "🥀", tags: ["plant", "flower"] },
      { name: "Herb", symbol: "🌿", tags: ["plant"] },
      { name: "Sheaf of Rice", symbol: "🌾", tags: ["plant", "food"] },
      { name: "shamrock", symbol: "☘️", tags: ["plant"] },
      { name: "Four Leaf Clover", symbol: "🍀", tags: ["plant"] },
      { name: "Mushroom", symbol: "🍄", tags: ["plant", "food"] },
      { name: "Chestnut", symbol: "🌰", tags: ["plant", "food"] },
      { name: "Coconut", symbol: "🥥", tags: ["plant", "food"] },
      { name: "Tomato", symbol: "🍅", tags: ["plant", "food"] },
      { name: "Eggplant", symbol: "🍆", tags: ["plant", "food"] },
      { name: "Grapes", symbol: "🍇", tags: ["plant", "food"] },
      { name: "melon", symbol: "🍈", tags: ["plant", "food"] },
      { name: "watermelon", symbol: "🍉", tags: ["plant", "food"] },
      { name: "tangerine", symbol: "🍊", tags: ["plant", "food"] },
      { name: "lemon", symbol: "🍋", tags: ["plant", "food"] },
      { name: "banana", symbol: "🍌", tags: ["plant", "food"] },
      { name: "pineapple", symbol: "🍍", tags: ["plant", "food"] },
      { name: "red apple", symbol: "🍎", tags: ["plant", "food"] },
      { name: "green apple", symbol: "🍏", tags: ["plant", "food"] },
      { name: "pear", symbol: "🍐", tags: ["plant", "food"] },
      { name: "peach", symbol: "🍑", tags: ["plant", "food"] },
      { name: "cherries", symbol: "🍒", tags: ["plant", "food"] },
      { name: "strawberry", symbol: "🍓", tags: ["plant", "food"] },
      { name: "Kiwi Fruit", symbol: "🥝", tags: ["plant", "food"] },
      { name: "Avocado", symbol: "🥑", tags: ["plant", "food"] },
      { name: "Potato", symbol: "🥔", tags: ["plant", "food"] },
      { name: "Carrot", symbol: "🥕", tags: ["plant", "food"] },
      { name: "Ear of Corn", symbol: "🌽", tags: ["plant", "food"] },
      { name: "Hot Pepper", symbol: "🌶️", tags: ["plant", "food"] },
      { name: "Cucumber", symbol: "🥒", tags: ["plant", "food"] },
      { name: "Broccoli", symbol: "🥦", tags: ["plant", "food"] },
      { name: "Peanuts", symbol: "🥜", tags: ["plant", "food"] },
      { name: "green salad", symbol: "🥗", tags: ["food"] },

      // sea animals
      { name: "spouting whale", symbol: "🐳", tags: ["animal", "ocean"] },
      { name: "whale", symbol: "🐋", tags: ["animal", "ocean"] },
      { name: "octopus", symbol: "🐙", tags: ["animal", "ocean"] },
      { name: "spiral shell", symbol: "🐚", tags: ["animal", "ocean"] },
      { name: "fish", symbol: "🐟", tags: ["animal", "ocean"] },
      { name: "tropical fish", symbol: "🐠", tags: ["animal", "ocean"] },
      { name: "blowfish", symbol: "🐡", tags: ["animal", "ocean"] },
      { name: "dolphin", symbol: "🐬", tags: ["animal", "ocean"] },
      { name: "shark", symbol: "🦈", tags: ["animal", "ocean"] },
      { name: "crab", symbol: "🦀", tags: ["animal", "ocean"] },
      { name: "shrimp", symbol: "🦐", tags: ["animal", "ocean"] },
      { name: "squid", symbol: "🦑", tags: ["animal", "ocean"] },

      // farm animals
      { name: "cow", symbol: "🐄", tags: ["animal", "farm"] },
      { name: "cow face", symbol: "🐮", tags: ["animal", "farm", "face"] },
      { name: "rooster", symbol: "🐓", tags: ["animal", "farm"] },
      { name: "chicken", symbol: "🐔", tags: ["animal", "farm", "face"] },
      { name: "hatching chick", symbol: "🐣", tags: ["animal", "farm"] },
      { name: "baby chick", symbol: "🐤", tags: ["animal", "farm"] },
      {
        name: "front-facing baby chick",
        symbol: "🐥",
        tags: ["animal", "farm"],
      },
      { name: "turkey", symbol: "🦃", tags: ["animal", "farm"] },
      { name: "pig", symbol: "🐖", tags: ["animal", "farm"] },
      { name: "pig face", symbol: "🐷", tags: ["animal", "farm", "face"] },
      { name: "pig nose", symbol: "🐽", tags: ["animal", "farm"] },
      { name: "horse", symbol: "🐎", tags: ["animal", "farm"] },
      { name: "horse face", symbol: "🐴", tags: ["animal", "farm", "face"] },
      { name: "ram", symbol: "🐏", tags: ["animal", "farm"] },
      { name: "ewe", symbol: "🐑", tags: ["animal", "farm"] },
      { name: "goat", symbol: "🐐", tags: ["animal", "farm"] },

      // companion animals
      { name: "Dog", symbol: "🐕", tags: ["animal", "companion"] },
      { name: "Poodle", symbol: "🐩", tags: ["animal", "companion"] },
      { name: "Dog Face", symbol: "🐶", tags: ["animal", "companion", "face"] },
      { name: "Paw Prints", symbol: "🐾", tags: ["animal", "companion"] },
      { name: "Cat", symbol: "🐈", tags: ["animal", "companion"] },
      { name: "Cat Face", symbol: "🐱", tags: ["animal", "companion", "face"] },
      { name: "Rat", symbol: "🐀", tags: ["animal", "companion"] },
      { name: "mouse", symbol: "🐁", tags: ["animal", "companion"] },
      {
        name: "mouse face",
        symbol: "🐭",
        tags: ["animal", "companion", "face"],
      },
      { name: "rabbit", symbol: "🐇", tags: ["animal", "companion"] },
      {
        name: "rabbit face",
        symbol: "🐰",
        tags: ["animal", "companion", "face"],
      },
      {
        name: "hamster face",
        symbol: "🐹",
        tags: ["animal", "companion", "face"],
      },

      // birds
      { name: "bird", symbol: "🐦", tags: ["animal", "wild"] },
      { name: "penguin", symbol: "🐧", tags: ["animal", "wild"] },
      { name: "dove", symbol: "🕊️", tags: ["animal", "wild", "activism"] },
      { name: "eagle", symbol: "🦅", tags: ["animal", "wild"] },
      { name: "duck", symbol: "🦆", tags: ["animal", "wild"] },
      { name: "owl", symbol: "🦉", tags: ["animal", "wild"] },
      { name: "Swan", symbol: "🦢", tags: ["animal", "wild"] },
      { name: "flamingo", symbol: "🦩", tags: ["animal", "wild"] },
      { name: "peacock", symbol: "🦚", tags: ["animal", "wild"] },
      { name: "parrot", symbol: "🦜", tags: ["animal", "wild"] },

      // bugs
      { name: "bug", symbol: "🐛", tags: ["animal", "wild"] },
      { name: "ant", symbol: "🐜", tags: ["animal", "wild"] },
      { name: "honeybee", symbol: "🐝", tags: ["animal", "wild"] },
      { name: "lady beetle", symbol: "🐞", tags: ["animal", "wild"] },
      { name: "snail", symbol: "🐌", tags: ["animal", "wild"] },
      { name: "butterfly", symbol: "🦋", tags: ["animal", "wild"] },
      { name: "cricket", symbol: "🦗", tags: ["animal", "wild"] },
      { name: "spider", symbol: "🕷️", tags: ["animal", "wild"] },
      { name: "spider web", symbol: "🕸️", tags: ["animal", "wild"] },
      { name: "scorpion", symbol: "🦂", tags: ["animal", "wild"] },

      { name: "tiger", symbol: "🐅", tags: ["animal", "wild"] },
      { name: "tiger face", symbol: "🐯", tags: ["animal", "wild", "face"] },
      { name: "lion face", symbol: "🦁", tags: ["animal", "wild", "face"] },
      { name: "leopard", symbol: "🐆", tags: ["animal", "wild"] },
      { name: "gorilla", symbol: "🦍", tags: ["animal", "wild"] },
      { name: "monkey", symbol: "🐒", tags: ["animal", "wild"] },
      { name: "monkey face", symbol: "🐵", tags: ["animal", "wild", "face"] },
      {
        name: "see-no-evil monkey",
        symbol: "🙈",
        tags: ["animal", "wild", "face"],
      },
      {
        name: "speak-no-evil monkey",
        symbol: "🙊",
        tags: ["animal", "wild", "face"],
      },
      {
        name: "hear-no-evil monkey",
        symbol: "🙉",
        tags: ["animal", "wild", "face"],
      },
      { name: "ox", symbol: "🐂", tags: ["animal"] },
      { name: "water buffalo", symbol: "🐃", tags: ["animal"] },
      { name: "dromedary camel", symbol: "🐪", tags: ["animal"] },
      { name: "bactrian camel", symbol: "🐫", tags: ["animal"] },
      { name: "zebra face", symbol: "🦓", tags: ["animal", "wild", "face"] },
      { name: "boar", symbol: "🐗", tags: ["animal", "wild", "face"] },
      { name: "elephant", symbol: "🐘", tags: ["animal", "wild"] },
      { name: "giraffe", symbol: "🦒", tags: ["animal", "wild", "face"] },
      { name: "rhinoceros", symbol: "🦏", tags: ["animal", "wild", "wild"] },
      { name: "koala", symbol: "🐨", tags: ["animal", "wild", "face"] },
      { name: "chipmunk", symbol: "🐿️", tags: ["animal", "wild"] },
      { name: "hedgehog", symbol: "🦔", tags: ["animal", "wild"] },
      { name: "bat", symbol: "🦇", tags: ["animal", "wild"] },
      { name: "raccoon", symbol: "🦝", tags: ["animal", "wild"] },
      { name: "otter", symbol: "🦦", tags: ["animal", "wild"] },
      //   { name: "bison", symbol: "🦬", tags: ["animal", "wild"]},
      { name: "deer", symbol: "🦌", tags: ["animal", "wild"] },
      { name: "Hippopotamus", symbol: "🦛", tags: ["animal", "wild"] },
      { name: "Orangutan", symbol: "🦧", tags: ["animal", "wild"] },
      { name: "Llama", symbol: "🦙", tags: ["animal", "wild"] },
      { name: "Hedgehog", symbol: "🦔", tags: ["animal", "wild"] },
      { name: "Sloth", symbol: "🦥", tags: ["animal", "wild"] },
      { name: "Skunk", symbol: "🦨", tags: ["animal", "wild"] },
      { name: "Kangaroo", symbol: "🦘", tags: ["animal", "wild"] },
      { name: "Badger", symbol: "🦡", tags: ["animal", "wild"] },

      { name: "Wolf Face", symbol: "🐺", tags: ["animal", "wild", "face"] },
      { name: "Bear Face", symbol: "🐻", tags: ["animal", "wild", "face"] },
      { name: "Panda Face", symbol: "🐼", tags: ["animal", "wild", "face"] },
      { name: "Turtle", symbol: "🐢", tags: ["animal", "wild"] },
      { name: "Frog Face", symbol: "🐸", tags: ["animal", "wild", "face"] },
      { name: "Crocodile", symbol: "🐊", tags: ["animal", "wild"] },
      { name: "Snake", symbol: "🐍", tags: ["animal", "wild"] },
      { name: "Lizard", symbol: "🦎", tags: ["animal", "wild"] },

      { name: "Meat on Bone", symbol: "🍖", tags: ["edge"] },
      { name: "Poultry Leg", symbol: "🍗", tags: ["edge"] },
      { name: "Cut of Meat", symbol: "🥩", tags: ["edge"] },
      { name: "Bacon", symbol: "🥓", tags: ["edge"] },
      { name: "Fried Shrimp", symbol: "🍤", tags: ["edge"] },
      { name: "Glass of Milk", symbol: "🥛", tags: ["edge", "food"] },
      { name: "cheese wedge", symbol: "🧀", tags: ["edge"] },
      { name: "Egg", symbol: "🥚", tags: ["animal", "farm", "edge"] },
      { name: "Hamburger", symbol: "🍔", tags: ["edge"] },
      { name: "Hot Dog", symbol: "🌭", tags: ["edge"] },
      { name: "Nauseated Face", symbol: "🤢", tags: ["edge"] },
      { name: "Face Vomiting", symbol: "🤮", tags: ["edge"] },
      { name: "Skull", symbol: "💀", tags: ["edge"] },
      { name: "Skull and Crossbones", symbol: "☠️", tags: ["edge"] },
      { name: "Thumbs Down", symbol: "👎", tags: ["edge"] },
      { name: "Raised Hand", symbol: "✋", tags: ["edge"] },
      { name: "Stop Sign", symbol: "🛑", tags: ["edge"] },
      { name: "Factory", symbol: "🏭", tags: ["edge"] },
      { name: "Dollar Banknote", symbol: "💵", tags: ["edge"] },
      { name: "Kitchen Knife", symbol: "🔪", tags: ["edge"] },

      { name: "Raised Fist", symbol: "✊", tags: ["activism"] },
      { name: "Raised Fist: Dark Skin Tone", symbol: "✊🏿", tags: ["activism"] },
      {
        name: "Raised Fist: Medium-Dark Skin Tone",
        symbol: "✊🏾",
        tags: ["activism"],
      },
      {
        name: "Raised Fist: Medium Skin Tone",
        symbol: "✊🏽",
        tags: ["activism"],
      },
      {
        name: "Raised Fist: Medium-Light Skin Tone",
        symbol: "✊🏼",
        tags: ["activism"],
      },
      {
        name: "Raised Fist: Light Skin Tone",
        symbol: "✊🏻",
        tags: ["activism"],
      },
      { name: "Victory Hand", symbol: "✌️", tags: ["activism"] },
      // { name: 'Victory Hand: Light Skin Tone', symbol: '✌️🏻', tags: ['activism'] },
      // { name: 'Victory Hand: Medium-Light Skin Tone', symbol: '✌️🏼', tags: ['activism'] },
      // { name: 'Victory Hand: Medium Skin Tone', symbol: '✌️🏽', tags: ['activism'] },
      // { name: 'Victory Hand: Medium-Dark Skin Tone', symbol: '✌️🏾', tags: ['activism'] },
      // { name: 'Victory Hand: Dark Skin Tone', symbol: '✌️🏿', tags: ['activism'] },
      { name: "Sign of the Horns", symbol: "🤘", tags: ["activism"] },
      {
        name: "Sign of the Horns: Light Skin Tone",
        symbol: "🤘🏻",
        tags: ["activism"],
      },
      {
        name: "Sign of the Horns: Medium-Light Skin Tone",
        symbol: "🤘🏼",
        tags: ["activism"],
      },
      {
        name: "Sign of the Horns: Medium Skin Tone",
        symbol: "🤘🏽",
        tags: ["activism"],
      },
      {
        name: "Sign of the Horns: Medium-Dark Skin Tone",
        symbol: "🤘🏾",
        tags: ["activism"],
      },
      {
        name: "Sign of the Horns: Dark Skin Tone",
        symbol: "🤘🏿",
        tags: ["activism"],
      },
      { name: "Black Heart", symbol: "🖤", tags: ["activism"] },
      { name: "White Heart", symbol: "🤍", tags: ["activism"] },
      { name: "Green Heart", symbol: "💚", tags: ["activism"] },
      { name: "Blue Heart", symbol: "💙", tags: ["activism"] },
      { name: "Orange Heart", symbol: "🧡", tags: ["activism"] },
      { name: "Red Heart", symbol: "❤️", tags: ["activism"] },
      { name: "Broken Heart", symbol: "💔", tags: ["activism"] },
      { name: "Loudspeaker", symbol: "📢", tags: ["activism"] },
      { name: "Bullhorn with Sound Waves", symbol: "🕬", tags: ["activism"] },
      { name: "Rainbow", symbol: "🌈", tags: ["activism", "nature"] },
      { name: "Peace Symbol", symbol: "☮️", tags: ["activism"] },
    ],
    tags: [],
    output: "",
    generate_tag: "animal",
    generate_count: 10,
  }),
  methods: {
    randomElement(arr) {
      return arr[Math.floor(Math.random() * arr.length)];
    },
    getEmojis(tag) {
      let r = [];
      for (let i = 0; i < this.symbols.length; ++i) {
        if (this.symbols[i].tags.indexOf(tag) !== -1) {
          r.push(this.symbols[i]);
        }
      }
      return r;
    },
    capitalize(text) {
      return text
        .toLowerCase()
        .split(" ")
        .map((s) => s.charAt(0).toUpperCase() + s.substring(1))
        .join(" ");
    },
    emojiClicked(emoji) {
      this.output += emoji.symbol;
      this.resizeTextArea();
    },
    randomEmoji(tag) {
      let emojis = this.getEmojis(tag);
      let emoji = this.randomElement(emojis);
      this.emojiClicked(emoji);
    },
    clearOutput() {
      this.output = "";
      this.resizeTextArea();
    },
    outputToArray() {
      let r = [];
      for (const ch of this.output) {
        r.push(ch);
      }
      let skin = ["🏻", "🏼", "🏽", "🏾", "🏿"];
      for (let i = 0; i < r.length; ++i) {
        if (skin.indexOf(r[i]) !== -1) {
          r[i - 1] += r[i];
          r.splice(i, 1);
          i -= 1;
        }
      }
      return r;
    },
    shuffleOutput() {
      let temp = this.outputToArray();
      this.output = "";
      while (temp.length > 0) {
        let index = Math.floor(Math.random() * temp.length);
        this.output += temp[index];
        temp.splice(index, 1);
      }
    },
    backspace() {
      let temp = this.outputToArray();
      temp.splice(temp.length - 1, 1);
      this.output = temp.join("");
      this.resizeTextArea();
    },
    copyOutput() {
      let emoji_output = document.querySelector("textarea");
      emoji_output.select();
      document.execCommand("copy");
      // this.clearSelection();
      //M.toast({html: 'copied to clipboard', displayLength: 750})
    },
    clearSelection() {
      var sel;
      if ((sel = document.selection) && sel.empty) {
        sel.empty();
      } else {
        if (window.getSelection) {
          window.getSelection().removeAllRanges();
        }
        var activeEl = document.activeElement;
        if (activeEl) {
          var tagName = activeEl.nodeName.toLowerCase();
          if (
            tagName == "textarea" ||
            (tagName == "input" && activeEl.type == "text")
          ) {
            // Collapse the selection to the end
            activeEl.selectionStart = activeEl.selectionEnd;
          }
        }
      }
    },
    resizeTextArea() {
      setTimeout(function () {
        //M.textareaAutoResize(document.querySelector('#emoji_output'))
      }, 50);
    },
    generateEmojis() {
      let emojis = this.getEmojis(this.generate_tag);
      for (let i = 0; i < this.generate_count; ++i) {
        let emoji = this.randomElement(emojis);
        this.output += emoji.symbol;
      }
      this.resizeTextArea();
    },
  },
  created: function () {
    for (let i = 0; i < this.symbols.length; ++i) {
      for (let j = 0; j < this.symbols[i].tags.length; ++j) {
        let tag = this.symbols[i].tags[j];
        if (this.tags.indexOf(tag) === -1) {
          this.tags.push(tag);
        }
      }
    }
    this.tags.sort();
  },
};
</script>
