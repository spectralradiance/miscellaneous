<template>
  <v-container>
    <transition-group id="tag_div" name="tags-list" tag="v-row">
      <v-btn
        color="primary"
        v-for="tag in selected_tags"
        v-on:click="removeElement(selected_tags, tag)"
        class="selected"
        tile
        v-bind:key="tag.name"
        >{{ tag.name }}<sup>{{ tag.count }}</sup></v-btn
      >
      <v-btn
        v-for="tag in sorted_tags"
        v-on:click="tagClicked(tag)"
        v-bind:key="tag.name"
        color="primary"
        outlined
        tile
        v-bind:class="[
          tag.group_border,
          { selected: !view_filter_tags && selected_tags.includes(tag) },
        ]"
        >{{ tag.name }}<sup>{{ tag.count }}</sup></v-btn
      >
      <v-btn
        key="z"
        color="primary"
        fab
        small
        :outlined="selected_tags.length == 0"
        v-bind:class="[
          selected_tags.length > 0
            ? 'clear_tags_active'
            : 'clear_tags_inactive',
        ]"
        v-on:click="selected_tags = []"
      >
        <v-icon>mdi-close</v-icon></v-btn
      >
    </transition-group>

    <transition-group id="bottom_div" name="bottom-div" tag="div">
      <transition-group
        id="inspirations_div"
        name="inspirations-list"
        tag="div"
        key="a"
      >
        <div
          v-for="inspiration in filtered_inspirations"
          v-bind:key="inspiration.name"
          class="inspirations-list-item"
          v-bind:class="{
            selected_inspiration: inspiration == selected_inspiration,
          }"
        >
          <template v-if="inspiration.is_artist">
            <div class="inspiration_artist">{{ inspiration.artist }}</div>
          </template>
          <template v-else>
            <span class="inspiration_year">{{ inspiration.release }}</span>
            <a
              v-if="!inspiration.embed_type"
              v-bind:href="inspiration.url"
              target="_blank"
              >{{ inspiration.name
              }}<span style="margin-left: 10px; opacity: 0.2">⤤</span></a
            >
            <a
              v-else
              href="#/"
              v-on:click="
                if (selected_inspiration == inspiration) {
                  selected_inspiration = null;
                } else {
                  selected_inspiration = inspiration;
                }
              "
              >{{ inspiration.name }}</a
            >
          </template>
        </div>
      </transition-group>
      <div class="inspiration_container" key="b">
        <div
          v-if="
            selected_inspiration &&
            selected_inspiration.embed_type == 'bandcamp'
          "
        >
          <iframe
            style="border: 0; width: 350px; height: 786px"
            v-bind:src="
              'https://bandcamp.com/EmbeddedPlayer/album=' +
              selected_inspiration.bandcamp_album_id +
              '/size=large/bgcol=333333/linkcol=ffffff/transparent=true/'
            "
            seamless
            ><a v-bind:href="selected_inspiration.url">⤤</a></iframe
          >
        </div>
        <div
          v-if="
            selected_inspiration &&
            selected_inspiration.embed_type == 'wikipedia'
          "
          v-html="wikipedia_summary"
          class="wikipedia_embed"
        ></div>
      </div>
    </transition-group>
  </v-container>
</template>
<script>
import axios from "axios";

/** todo
 * fix leave animation on inspirations
 * mc escher, biksinsky, alex grey
 * inspiration - display artist
 * if no embed - display more info
 * rating / 5
 * embed wikipedia - use api to get summary and image
 **/
let inspirations = [
  {
    name: "The Fountain",
    artist: "Darren Aronofsky",
    release: "2006",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/The_Fountain",
    tags: ["film"],
  },
  {
    name: "Princess Mononoke",
    artist: "Hayao Miyazaki",
    release: "1997",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Princess_Mononoke",
    tags: ["film", "anime"],
  },
  {
    name: "Ghost in the Shell",
    artist: "Mamoru Oshii",
    release: "1996",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Ghost_in_the_Shell_(1995_film)",
    tags: ["film", "anime"],
  },
  {
    name: "Serial Experiments Lain",
    artist: "Triangle Staff",
    release: "1998",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Serial_Experiments_Lain",
    tags: ["tv", "anime", "nostalgia"],
  },
  {
    name: "Fullmetal Alchemist: Brotherhood",
    artist: "Bones",
    release: "2009",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Fullmetal_Alchemist:_Brotherhood",
    tags: ["tv", "anime", "nostalgia"],
  },
  {
    name: "Outlaw Star",
    artist: "Sunrise",
    release: "1998",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Outlaw_Star#Anime",
    tags: ["tv", "anime", "nostalgia"],
  },
  {
    name: "Cowboy Bebop",
    artist: "Sunrise",
    release: "1997",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Cowboy_Bebop",
    tags: ["tv", "anime", "nostalgia"],
  },
  {
    name: "Samurai Champloo",
    artist: "Manglobe",
    release: "2004",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Samurai_Champloo",
    tags: ["tv", "anime", "nostalgia"],
  },
  {
    name: "Dragon Ball Z",
    artist: "Toei Animation",
    release: "1989",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Dragon_Ball_Z",
    tags: ["tv", "anime", "nostalgia"],
  },
  {
    name: "Neon Genesis Evangelion",
    artist: "Gainax and Tatsunoko Production",
    release: "1995",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Neon_Genesis_Evangelion",
    tags: ["tv", "anime", "nostalgia"],
  },
  {
    name: "Trigun",
    artist: "Yasuhiro Nightow, Madhouse",
    release: "1998",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Trigun#Anime",
    tags: ["anime", "nostalgia"],
  },
  {
    name: "Blue Gender",
    artist: "Masashi Abe and Ryōsuke Takahashi",
    release: "1999",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Blue_Gender",
    tags: ["anime", "nostalgia"],
  },

  // GAMES =================================================================
  {
    name: "Sonic 3 & Knuckles",
    artist: "Sega",
    release: "1994",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Sonic_the_Hedgehog_3#Sonic_the_Hedgehog_3_&_Knuckles",
    tags: ["game", "nostalgia"],
  },
  {
    name: "Zone of the Enders",
    artist: "Konami",
    release: "2001",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Zone_of_the_Enders_(video_game)",
    tags: ["game", "nostalgia"],
  },
  {
    name: "Halo: Combat Evolved",
    artist: "Bungie",
    release: "2003",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Halo:_Combat_Evolved",
    tags: ["game", "pc"],
  },
  {
    name: "Devil May Cry",
    artist: "Capcom",
    release: "2001",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Devil_May_Cry",
    tags: ["game", "ps2"],
  },
  {
    name: "ICO",
    artist: "Team Ico",
    release: "2001",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Ico",
    tags: ["game", "ps2"],
  },
  {
    name: "Shadow of the Colossus",
    artist: "Team Ico",
    release: "2001",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Shadow_of_the_Colossus",
    tags: ["game", "ps2"],
  },
  {
    name: "Journey",
    artist: "Thatgamecompany",
    release: "2012",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Journey_(2012_video_game)",
    tags: ["game", "ps3"],
  },
  {
    name: "Dark Souls III",
    artist: "FromSoftware",
    release: "2016",
    embed_type: "wikipedia",
    url: "https://www.bandainamcoent.com/games/dark-souls-iii",
    tags: ["game", "pc"],
  },
  {
    name: "Fez",
    artist: "Polytron Corporation",
    release: "2013",
    embed_type: "wikipedia",
    url: "http://fezgame.com/",
    tags: ["game"],
  },
  {
    name: "Hyper Light Drifter",
    artist: "Heart Machine",
    release: "2016",
    embed_type: "wikipedia",
    url: "http://www.heart-machine.com/",
    tags: ["game"],
  },
  {
    name: "Celeste",
    artist: "Matt Makes Games",
    release: "2018",
    embed_type: "wikipedia",
    url: "http://www.celestegame.com/",
    tags: ["game"],
  },
  {
    name: "Kirby & the Amazing Mirror",
    artist: "HAL Laboratory",
    release: "2004",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Kirby_%26_the_Amazing_Mirror",
    tags: ["game", "gba", "nostalgia"],
  },
  {
    name: "The Legend of Zelda: The Minish Cap",
    artist: "Capcom",
    release: "2005",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/The_Legend_of_Zelda:_The_Minish_Cap",
    tags: ["game", "gba", "nostalgia"],
  },
  {
    name: "Spyro the Dragon",
    artist: "Insomniac Games",
    release: "1998",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Spyro_the_Dragon",
    tags: ["game", "psx", "nostalgia"],
  },
  {
    name: "Spyro 2: Ripto's Rage!",
    artist: "Insomniac Games",
    release: "1999",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Spyro_2:_Ripto%27s_Rage!",
    tags: ["game", "psx", "nostalgia"],
  },
  {
    name: "Spyro: Year of the Dragon",
    artist: "Insomniac Games",
    release: "2000",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Spyro:_Year_of_the_Dragon",
    tags: ["game", "psx", "nostalgia"],
  },
  {
    name: "Mega Man Legends 2",
    artist: "Capcom",
    release: "2000",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Mega_Man_Legends_2",
    tags: ["game", "psx", "nostalgia"],
  },
  {
    name: "Ape Escape",
    artist: "SCE Japan Studio",
    release: "2005",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Ape_Escape_(video_game)",
    tags: ["game", "psx", "nostalgia"],
  },
  {
    name: "Guild Wars",
    artist: "ArenaNet",
    release: "2005",
    embed_type: "wikipedia",
    url: "https://www.guildwars.com/en/",
    tags: ["game", "pc", "nostalgia"],
  },
  {
    name: "Armored Core: For Answer",
    artist: "FromSoftware",
    release: "2008",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Armored_Core:_For_Answer",
    tags: ["game"],
  },

  // books =================================================================
  {
    name: "The Hero with a Thousand Faces",
    artist: "Joseph Campbell",
    release: "1949",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/The_Hero_with_a_Thousand_Faces",
    tags: ["book"],
  },
  {
    name: "A Brief History of Time",
    artist: "Stephen Hawking",
    release: "1988",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/A_Brief_History_of_Time",
    tags: ["book", "science"],
  },
  {
    name: "Unweaving the Rainbow",
    artist: "Richard Dawkins",
    release: "1998",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Unweaving_the_Rainbow",
    tags: ["book", "science"],
  },
  {
    name: "The Consolation of Philosophy",
    artist: "Boethius",
    release: "524",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/The_Consolation_of_Philosophy",
    tags: ["book", "philosophy", "poetry"],
  },
  {
    name: "Beowulf",
    artist: "Unknown",
    release: "975",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Beowulf",
    tags: ["book", "poetry"],
  },
  {
    name: "The Prose Edda",
    artist: "Snorri Sturluson",
    release: "1220",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Prose_Edda",
    tags: ["book", "poetry"],
  },
  {
    name: "The Divine Comedy",
    artist: "Dante Alighieri",
    release: "1320",
    embed_type: "wikipedia",
    url: "https://en.wikipedia.org/wiki/Divine_Comedy",
    tags: ["book", "poetry"],
  },

  // MUSIC ===============================================================
  {
    name: "Soundtrack to a Vacant Life",
    artist: "The Flashbulb",
    release: "2008",
    embed_type: "bandcamp",
    bandcamp_album_id: "4198308764",
    url: "https://theflashbulb.bandcamp.com/album/soundtrack-to-a-vacant-life",
    tags: ["music", "electronica"],
  },
  {
    name: "Dive",
    artist: "Tycho",
    release: "2015",
    embed_type: "bandcamp",
    bandcamp_album_id: "3619628392",
    url: "https://tycho.bandcamp.com/album/dive",
    tags: ["music", "electronica"],
  },
  {
    name: "FEZ OST",
    artist: "Disasterpeace",
    release: "2012",
    embed_type: "bandcamp",
    bandcamp_album_id: "688853505",
    url: "https://music.disasterpeace.com/album/fez-ost",
    tags: ["music", "electronica"],
  },
  {
    name: "Hyper Light Drifter OST",
    artist: "Disasterpeace",
    release: "2016",
    embed_type: "bandcamp",
    bandcamp_album_id: "2303268128",
    url: "https://music.disasterpeace.com/album/hyper-light-drifter",
    tags: ["music", "electronica"],
  },
  {
    name: "To Live",
    artist: "bvdub",
    release: "2009",
    embed_type: "bandcamp",
    bandcamp_album_id: "2306392998",
    url: "https://bvdub.bandcamp.com/album/to-live",
    tags: ["music", "electronica"],
  },
  {
    name: "We Were the Sun",
    artist: "bvdub",
    release: "2009",
    embed_type: "bandcamp",
    bandcamp_album_id: "4266696895",
    url: "https://bvdub.bandcamp.com/album/we-were-the-sun",
    tags: ["music", "electronica"],
  },
  {
    name: "The Art of Dying Alone",
    artist: "bvdub",
    release: "2010",
    embed_type: "bandcamp",
    bandcamp_album_id: "4075803671",
    url: "https://bvdub.bandcamp.com/album/the-art-of-dying-alone",
    tags: ["music", "electronica"],
  },
  {
    name: "I Remember (Translations of Mørketid)",
    artist: "bvdub",
    release: "2011",
    embed_type: "bandcamp",
    bandcamp_album_id: "1479213977",
    url: "https://bvdub.bandcamp.com/album/i-remember-translations-of-m-rketid",
    tags: ["music", "electronica"],
  },
  {
    name: "One Last Look at the Sea",
    artist: "bvdub",
    release: "2011",
    embed_type: "bandcamp",
    bandcamp_album_id: "547930773",
    url: "https://bvdub.bandcamp.com/album/one-last-look-at-the-sea",
    tags: ["music", "electronica"],
  },
  {
    name: "Resistance is Beautiful",
    artist: "bvdub",
    release: "2011",
    embed_type: "bandcamp",
    bandcamp_album_id: "3834218025",
    url: "https://bvdubdarla.bandcamp.com/album/resistance-is-beautiful",
    tags: ["music", "electronica"],
  },
  {
    name: "Songs For a Friend I Left Behind",
    artist: "bvdub",
    release: "2011",
    embed_type: "bandcamp",
    bandcamp_album_id: "726201853",
    url: "https://bvdub.bandcamp.com/album/songs-for-a-friend-i-left-behind",
    tags: ["music", "electronica"],
  },
  {
    name: "The Truth Hurts",
    artist: "bvdub & Ian Hawgood",
    release: "2011",
    embed_type: "bandcamp",
    bandcamp_album_id: "1103152910",
    url: "https://bvdub.bandcamp.com/album/bvdub-ian-hawgood-the-truth-hurts",
    tags: ["music", "electronica"],
  },
  {
    name: "Then",
    artist: "bvdub",
    release: "2011",
    embed_type: "bandcamp",
    bandcamp_album_id: "485530863",
    url: "https://bvdub.bandcamp.com/album/then",
    tags: ["music", "electronica"],
  },
  {
    name: "Tribes at the Temple of Silence",
    artist: "bvdub | Brock Van Wey",
    release: "2011",
    embed_type: "bandcamp",
    bandcamp_album_id: "32579493",
    url: "https://bvdub.bandcamp.com/album/tribes-at-the-temple-of-silence",
    tags: ["music", "electronica"],
  },
  {
    name: "All is Forgiven",
    artist: "bvdub | Brock Van Wey",
    release: "2012",
    embed_type: "bandcamp",
    bandcamp_album_id: "2717876220",
    url: "https://bvdub.bandcamp.com/album/all-is-forgiven",
    tags: ["music", "electronica"],
  },
  {
    name: "Serenity",
    artist: "bvdub",
    release: "2012",
    embed_type: "bandcamp",
    bandcamp_album_id: "2966618244",
    url: "https://darlamusic.bandcamp.com/album/serenity",
    tags: ["music", "electronica"],
  },
  {
    name: "The First Day",
    artist: "bvdub",
    release: "2012",
    embed_type: "bandcamp",
    bandcamp_album_id: "3780479369",
    url: "https://bvdub.bandcamp.com/album/the-first-day",
    tags: ["music", "electronica"],
  },
  {
    name: "A Careful Ecstacy",
    artist: "bvdub",
    release: "2013",
    embed_type: "bandcamp",
    bandcamp_album_id: "1214424874",
    url: "https://bvdubdarla.bandcamp.com/album/a-careful-ecstasy",
    tags: ["music", "electronica"],
  },
  {
    name: "Erebus",
    artist: "bvdub & Loscil",
    release: "2013",
    embed_type: "bandcamp",
    bandcamp_album_id: "481442721",
    url: "https://glacialmovements.bandcamp.com/album/erebus",
    tags: ["music", "electronica"],
  },
  {
    name: "I'll Only Break Your Heart",
    artist: "bvdub",
    release: "2014",
    embed_type: "bandcamp",
    bandcamp_album_id: "2055577654",
    url: "https://bvdubdarla.bandcamp.com/album/ill-only-break-your-heart",
    tags: ["music", "electronica"],
  },
  {
    name: "Home",
    artist: "bvdub",
    release: "2015",
    embed_type: "bandcamp",
    bandcamp_album_id: "200675916",
    url: "https://bvdub.bandcamp.com/album/brock-van-wey-home",
    tags: ["music", "electronica"],
  },
  {
    name: "Selected Ambient Works",
    artist: "Aphex Twin",
    release: "1992",
    embed_type: "bandcamp",
    bandcamp_album_id: "1881652386",
    url: "https://apollorecords.bandcamp.com/album/selected-ambient-works-85-92",
    tags: ["music", "electronica"],
  },
  {
    name: "Hail Wind and Hewn Oak",
    artist: "Falls of Rauros",
    release: "2008",
    embed_type: "bandcamp",
    bandcamp_album_id: "3214186951",
    url: "https://fallsofrauros.bandcamp.com/album/hail-wind-and-hewn-oak-2015-remaster",
    tags: ["music", "metal"],
  },
  {
    name: "The Light That Dwells in Rotten Wood",
    artist: "Falls of Rauros",
    release: "2013",
    embed_type: "bandcamp",
    bandcamp_album_id: "1602169422",
    url: "https://fallsofrauros.bandcamp.com/album/the-light-that-dwells-in-rotten-wood-2013-remaster",
    tags: ["music", "metal"],
  },
  {
    name: "Empires of Ash",
    artist: "Sojourner",
    release: "2016",
    embed_type: "bandcamp",
    bandcamp_album_id: "237208640",
    url: "https://sojournermetal.bandcamp.com/album/empires-of-ash",
    tags: ["music", "metal"],
  },
  {
    name: "Mammal",
    artist: "Altar of Plagues",
    release: "2011",
    embed_type: "",
    url: "https://www.metal-archives.com/albums/Altar_of_Plagues/Mammal/299885",
    tags: ["music", "metal"],
  },
  {
    name: "White Tomb",
    artist: "Altar of Plagues",
    release: "2009",
    embed_type: "",
    url: "https://www.metal-archives.com/albums/Altar_of_Plagues/White_Tomb/225046",
    tags: ["music", "metal"],
  },
  {
    name: "Of Dirt",
    artist: "Woman is the Earth",
    release: "2009",
    embed_type: "",
    url: "https://www.metal-archives.com/albums/Woman_Is_the_Earth/Of_Dirt/339409",
    tags: ["music", "metal"],
  },
  {
    name: "This Place That Contains My Spirit",
    artist: "Woman is the Earth",
    release: "2011",
    embed_type: "bandcamp",
    bandcamp_album_id: "469308340",
    url: "https://womanistheearth.bandcamp.com/album/this-place-that-contains-my-spirit",
    tags: ["music", "metal"],
  },
  {
    name: "Two Hunters",
    artist: "Wolves in the Throne Room",
    release: "2007",
    embed_type: "bandcamp",
    bandcamp_album_id: "2456241413",
    url: "https://wolvesinthethroneroom.bandcamp.com/album/two-hunters",
    tags: ["music", "metal"],
  },
  {
    name: "Celestial Lineage",
    artist: "Wolves in the Throne Room",
    release: "2011",
    embed_type: "bandcamp",
    bandcamp_album_id: "734137787",
    url: "https://wolvesinthethroneroom.bandcamp.com/album/celestial-lineage",
    tags: ["music", "metal"],
  },
  {
    name: "In Turmoil",
    artist: "ANCST",
    release: "2014",
    embed_type: "bandcamp",
    bandcamp_album_id: "3589489578",
    url: "https://angstnoise.bandcamp.com/album/in-turmoil",
    tags: ["music", "metal"],
  },
  {
    name: "The Gathering Wilderness",
    artist: "Primordial",
    release: "2005",
    embed_type: "bandcamp",
    bandcamp_album_id: "419868551",
    url: "https://primordialofficial.bandcamp.com/album/the-gathering-wilderness",
    tags: ["music", "metal"],
  },
  {
    name: "Sunbather",
    artist: "Deafheaven",
    release: "2013",
    embed_type: "bandcamp",
    bandcamp_album_id: "4022394178",
    url: "https://deafheavens.bandcamp.com/album/sunbather",
    tags: ["music", "metal"],
  },
  {
    name: "Roads to the North",
    artist: "Panopticon",
    release: "2014",
    embed_type: "bandcamp",
    bandcamp_album_id: "3456041268",
    url: "https://thetruepanopticon.bandcamp.com/album/roads-to-the-north",
    tags: ["music", "metal"],
  },
  {
    name: "Kentucky",
    artist: "Panopticon",
    release: "2012",
    embed_type: "bandcamp",
    bandcamp_album_id: "2235870668",
    url: "https://thetruepanopticon.bandcamp.com/album/kentucky",
    tags: ["music", "metal"],
  },
];

// show domain on link "bandcamp.com" / "wikipedia.org"
// show count on tags

let tag_groups = [
  ["music", "electronica", "metal"],
  ["game", "gba", "psx", "ps2", "ps3", "pc"],
  ["book", "science", "philosophy", "poetry"],
  ["film", "tv", "anime"],
];

export default {
  data() {
    return {
      inspirations: inspirations,
      selected_inspiration: null,
      tags: [],
      selected_tags: [],
      view_tag_groups: true,
      view_filter_tags: true,
      wikipedia_summary: "",
    };
  },
  methods: {
    clearTagSelection: function () {
      for (let i = 0; i < this.tags.length; ++i) {
        this.tags[i].selected = false;
      }
    },
    removeElement(array, element) {
      array.splice(array.indexOf(element), 1);
    },
    tagClicked(tag) {
      if (this.selected_tags.includes(tag)) {
        this.removeElement(this.selected_tags, tag);
      } else if (this.view_filter_tags) {
        this.selected_tags.push(tag);
      } else {
        this.selected_tags = [tag];
      }
    },
    loadWikipediaSummary(inspiration) {
      let article_name = inspiration.name.replace(" ", "%20");
      let url =
        "https://en.wikipedia.org/w/api.php?origin=*&format=json&action=query&prop=extracts&exintro&explaintext&redirects=1&titles=" +
        article_name;
      axios.get(url).then((response) => {
        let results = response.data.query.pages;
        this.wikipedia_summary =
          results[Object.getOwnPropertyNames(results)[0]].extract;
      });
    },
  },
  watch: {
    selected_inspiration: function (v) {
      if (v) {
        if (v.embed_type == "wikipedia") {
          this.loadWikipediaSummary(v);
        }
      }
    },
  },
  computed: {
    sorted_tags: function () {
      let tags = this.tags.slice();

      if (this.view_filter_tags) {
        tags = tags.filter((tag) => {
          return !this.selected_tags.includes(tag);
        });

        let inspirations = this.filtered_inspirations;

        // kluge - remove artist entries
        inspirations = inspirations.filter((t) => !t.is_artist);

        // only include tags that are on the filtered inspirations
        tags = tags.filter(function (tag) {
          for (let i = 0; i < inspirations.length; ++i) {
            if (inspirations[i].tags.includes(tag.name)) {
              return true;
            }
          }
          return false;
        });

        // recalculate the counts
        for (let i = 0; i < tags.length; ++i) {
          tags[i].count = 0;
          for (let j = 0; j < inspirations.length; ++j) {
            if (inspirations[j].tags.includes(tags[i].name)) {
              // TODO - this will have to change when hierarchies are introduced
              tags[i].count += 1;
            }
          }
        }
      }

      tags.sort(function (a, b) {
        if (a.count < b.count) {
          return 1;
        } else if (a.count > b.count) {
          return -1;
        } else {
          if (a.name > b.name) {
            return 1;
          } else if (a.name < b.name) {
            return -1;
          } else {
            return 0;
          }
        }
      });

      if (this.view_tag_groups) {
        let tags2 = [];
        for (let i = 0; i < tag_groups.length; ++i) {
          let t = [];
          for (let j = 0; j < tag_groups[i].length; ++j) {
            for (let k = 0; k < tags.length; ++k) {
              if (tag_groups[i][j] == tags[k].name) {
                let tag = tags[k];
                t.push(tag);
                this.removeElement(tags, tag);
                break;
              }
            }
          }
          if (t.length == 1) {
            t[0].group_border = "";
          } else {
            for (let j = 0; j < t.length; ++j) {
              if (j == 0) {
                t[j].group_border = "group_border_left";
              } else if (j == t.length - 1) {
                t[j].group_border = "group_border_right";
              } else {
                t[j].group_border = "group_border_center";
              }
              tags2.push(t[j]);
            }
          }
        }
        for (let i = 0; i < tags.length; ++i) {
          tags[i].group_border = "";
        }
        tags = tags2.concat(tags);
      } else {
        for (let i = 0; i < tags.length; ++i) {
          tags[i].group_border = "";
        }
      }
      return tags;
    },
    filtered_inspirations: function () {
      let r = this.inspirations.slice(0);
      for (let i = 0; i < this.selected_tags.length; ++i) {
        r = r.filter((a) => a.tags.includes(this.selected_tags[i].name));
      }
      // let r = this.inspirations.filter(function(a) {
      //   for (let i=0; i<app.tags.length; ++i) {
      //     if (app.tags[i].selected && a.tags.includes(app.tags[i])) {
      //       return true
      //     }
      //   }
      //   return false
      // })

      // sort first by artist, then by release
      r.sort(function (a, b) {
        if (a.artist.toLowerCase() < b.artist.toLowerCase()) {
          return -1;
        } else if (a.artist.toLowerCase() > b.artist.toLowerCase()) {
          return 1;
        } else {
          if (a.release < b.release) {
            return -1;
          } else if (a.release > b.release) {
            return 1;
          } else {
            return 0;
          }
        }
      });

      // inject artist entries into list
      for (let i = 0; i < r.length; ) {
        r.splice(i, 0, {
          is_artist: true,
          name: r[i].artist,
          artist: r[i].artist,
        });
        let j = i;
        while (i < r.length && r[j].artist == r[i].artist) {
          ++i;
        }
      }

      return r;
    },
  },
  mounted() {
    for (let i = 0; i < this.inspirations.length; ++i) {
      for (let j = 0; j < this.inspirations[i].tags.length; ++j) {
        let k = 0;
        for (; k < this.tags.length; ++k) {
          if (this.tags[k].name == this.inspirations[i].tags[j]) {
            break;
          }
        }

        if (k === this.tags.length) {
          // tag was not found, add it
          this.tags.push({
            name: this.inspirations[i].tags[j],
            count: 1,
            selected: false,
          });
        } else {
          // tag was found, increment its count
          this.tags[k].count++;
        }
      }
    }
  },
};
</script>
<style scoped>
* {
  transition: all ease 0.2s;
}
.tags-list-leave-active {
  position: absolute;
}
#tag_div {
  margin-top: 30px;
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
}
#tag_div > * {
  margin-right: 10px;
}

.bottom-div-enter,
.bottom-div-leave-to {
  opacity: 0;
  /* translate: translateY(30px) */
}
.bottom-div-move {
  transition: transform 0.5s;
}

.selected {
  /* color: black; */
  /* background-color: white; */
}
.tags-list-enter,
.tags-list-leave-to {
  opacity: 0;
  /* translate: translateY(30px) */
}
.tags-list-move {
  transition: transform 0.5s;
}
/* .flip-list-item {
    transition: all 1s;
  } */

.group_border_left {
  border-right: none !important;
  margin-right: 0 !important;
  border-top-right-radius: 0 !important;
  border-bottom-right-radius: 0 !important;
}
.group_border_center {
  border-left: none !important;
  border-right: none !important;
  margin-left: 0 !important;
  margin-right: 0 !important;
}
.group_border_right {
  border-left: none !important;
  margin-left: 0 !important;
  border-top-left-radius: 0 !important;
  border-bottom-left-radius: 0 !important;
}

#bottom_div {
  display: flex;
  flex-direction: row;
  justify-content: center;
  flex-wrap: wrap-reverse;
  margin-top: 30px;
  position: relative;
}

.bottom-div > * {
  transition: all 0.5s;
  display: inline-block;
}

.bottom-div-enter,
.bottom-div-leave-to {
  opacity: 0;
  /* translate: translateY(30px) */
}
.bottom-div-leave-active {
  position: fixed;
}

#inspirations_div {
  width: 500px;
  display: flex;
  flex-direction: column;
}

.inspirations-list-item {
  transition: all 0.5s;
  display: inline-block;
}
.inspirations-list-enter,
.inspirations-list-leave-to {
  opacity: 0;
  /* translate: translateY(30px) */
}
.inspirations-list-leave-active {
  position: fixed;
}

.inspiration_year {
  display: inline-block;
  width: 46px;
  opacity: 0.8;
}
.inspiration_artist {
  display: inline-block;
  width: 200px;
  opacity: 0.8;
  font-size: 20px;
  margin-top: 20px;
}
.selected_inspiration {
  margin-top: 20px !important;
  margin-bottom: 20px !important;
}
.selected_inspiration > a {
  font-size: 24px;
}
.wikipedia_embed {
  width: 500px;
}
</style>
