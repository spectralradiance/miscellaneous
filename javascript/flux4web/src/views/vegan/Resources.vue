<template>
  <v-container fluid class="resources">
    <v-row>
      <h1>Resources</h1>
    </v-row>
    <v-row>
      <v-col class="filter_column">
        <v-btn-toggle v-model="selected_resource_type" tile>
          <v-btn
            v-for="(resource_type, index) in resource_types"
            :key="index"
            :value="resource_type"
            small
            class="primary"
          >
            {{ resource_type }}
          </v-btn>
        </v-btn-toggle>
      </v-col>
    </v-row>
    <v-row>
      <v-expansion-panels>
        <v-expansion-panel v-for="(resource, i) in filteredResources" :key="i">
          <v-expansion-panel-header>
            <div>
              <h2>{{ resource.name }}</h2>
              <h4 class="resource_author">
                <span>{{ resource.type | capitalize }}</span>
                <span v-if="resource.author"> / {{ resource.author }}</span>
              </h4>
            </div>
            <div class="link_container">
              <a :href="resource.url" target="_blank"
                >&nbsp;<v-icon @click.native.stop color="primary"
                  >mdi-link-variant</v-icon
                ></a
              >
            </div>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <div v-html="resource.description"></div>
            <span
              ><a
                v-for="(url, j) in resource.urls"
                :key="j"
                :href="url"
                class="group_link"
                target="_blank"
                ><v-icon>{{ findIconForUrl(url) }}</v-icon></a
              ></span
            >
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
  max-width: 800px;
  margin: 0 auto;
}
.resource_author {
  margin-top: 4px;
}
.v-btn-toggle {
  flex-wrap: wrap;
  justify-content: center;
  background-color: transparent !important;
}
.v-btn-toggle .v-btn {
  margin: 2px;
}
.filter_column {
  padding: 12px 0 !important;
}
.v-btn-toggle .v-btn.theme--light:not(.v-btn--active) {
  background-color: transparent !important;
  border: 1px solid grey;
}
.v-btn-toggle .v-btn.theme--dark:not(.v-btn--active) {
  background-color: transparent !important;
  border: 1px solid grey;
}
.v-btn-toggle .v-btn.theme--light:not(.v-btn--active) .v-btn__content {
  color: black !important;
}

.v-btn-toggle .theme--light .v-btn__content {
  color: white;
}
.v-btn-toggle .v-btn--active.theme--light .v-btn__content {
  color: white;
}
.link_container {
  display: flex;
  flex-direction: row-reverse;
  align-items: center;
  padding-right: 10px;
}
</style>
<script>
export default {
  name: "Resources",
  data: () => ({
    resource_types: [
      "app",
      "article",
      "book",
      "documentary",
      "film",
      "video",
      "website",
    ], // 'business', 'restaurant'],
    selected_resource_type: null,
    resources: [
      {
        name: "VegMovies",
        url: "https://www.vegmovies.com/",
        author: "Veg Groups",
        description:
          '"We are the largest directory of plant-based and animal-friendly movies. Find something to watch or recommend today."',
        type: "website",
        urls: ["https://www.vegmovies.com/"],
        submission_status: "approved",
      },
      {
        name: "Faunalytics",
        url: "https://faunalytics.org/",
        author: "",
        description: "",
        type: "website",
        urls: [
          "https://www.facebook.com/faunalytics",
          "https://twitter.com/faunalytics",
          "https://www.instagram.com/faunalytics/",
          "https://www.linkedin.com/company/faunalytics/",
        ],
        submission_status: "approved",
      },
      {
        name: "Animal Charity Evaluators",
        url: "https://animalcharityevaluators.org/",
        author: "",
        description: "",
        type: "website",
        urls: [
          "https://www.facebook.com/AnimalCharityEvaluators/",
          "https://twitter.com/AnimalCharityEv",
          "https://www.instagram.com/animalcharityevaluators/",
          "https://www.youtube.com/channel/UCdRLnvaAMvvfh0wif9EReWw",
          "https://www.linkedin.com/company/animal-charity-evaluators/",
          "https://medium.com/@animalcharityev",
        ],
        submission_status: "approved",
      },
      {
        name: "Earthlings",
        url: "http://www.nationearth.com/",
        author: "Writer & Director: Shaun Monson",
        description:
          '"Using hidden cameras and never-before-seen footage, Earthlings chronicles the day-to-day practices of the largest industries in the world, all of which rely entirely on animals for profit."',
        type: "documentary",
        urls: ["http://www.nationearth.com/"],
        submission_status: "approved",
      },
      {
        name: "Dominion",
        url: "https://www.dominionmovement.com/",
        author: "Writer & Director: Chris Delforce",
        description:
          '"Exposing the dark underbelly of modern animal agriculture through drones, hidden & handheld cameras, the feature-length film explores the morality and validity of our dominion over the animal kingdom. Now available to watch online for free."',
        type: "documentary",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Cowspiracy: The Sustainability Secret",
        url: "http://www.cowspiracy.com/",
        author: "Writer & Director: Kip Andersen, Keegan Kuhn",
        description:
          '"The World\'s largest environmental organizations are failing to address the single most destructive force facing the planet today. Follow the shocking, yet humorous, journey of an aspiring environmentalist, as he daringly seeks to find the real solution to the most pressing environmental issues and true path to sustainability."',
        type: "documentary",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Forks Over Knives",
        url: "https://www.netflix.com/title/70185045",
        author: "Writer & Director: Lee Fulkerson",
        description:
          '"Examines the profound claim that most, if not all, of the degenerative diseases that afflict us can be controlled, or even reversed, by rejecting our present menu of animal-based and processed foods."',
        type: "documentary",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Truth or Drought",
        url: "https://www.truthordrought.com/",
        author: "",
        description:
          '"Truth or Drought is a science-based grassroots campaign making the undeniable connection between animal consumption and environmental breakdown."',
        type: "website",
        urls: [
          "https://www.facebook.com/truthordrought",
          "https://www.instagram.com/truthordrought/",
          "https://twitter.com/TruthOrDrought",
          "https://www.youtube.com/channel/UCi44QHTSmHwcNELEyk0nBZw",
        ],
        submission_status: "approved",
      },
      {
        name: "Vegan Cheat Sheet",
        url: "https://vegancheatsheet.org/",
        author: "The Vegan Hacktivists",
        description: "A massive compilation of vegan resources.",
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Vegan Starter Kit",
        url: "https://www.vegankit.com/",
        author: "",
        description:
          '"Vegankit is an online all-in-one page for becoming and staying vegan"',
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "101 Reasons to Go Vegan",
        url: "https://www.youtube.com/watch?v=YnQb58BoBQw",
        author:
          "James Wildman of the Animal Rights Foundation of Florida (http://arff.org)",
        description:
          '"A fascinating and entertaining presentation on the ethical solutions and health benefits of veganism by James Wildman of the Animal Rights Foundation of Florida"',
        type: "video",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "5 Minutes 5 Vegans",
        url: "https://5minutes5vegans.org/",
        author: "The Vegan Hacktivists",
        description:
          '"In just 5 minutes or less you can help 5 or more people become Vegan right now - it\'s fast, simple, and free!"',
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "A Prayer for Compassion",
        url: "http://aprayerforcompassion.com/",
        author: "",
        description:
          '"A Prayer for Compassion is a feature length documentary that strives to inspire and encourage those already on a religious or spiritual path, to expand their circle of compassion to embrace all life, regardless of species, and make choices in alignment with this value."',
        type: "documentary",
        urls: [
          "http://aprayerforcompassion.com/",
          "https://www.facebook.com/CompassionMovie/",
          "https://www.instagram.com/compassionmovie/",
          "https://twitter.com/CompassionMovie",
        ],
        submission_status: "approved",
      },
      {
        name: "Unlocking the Cage",
        url: "https://www.unlockingthecagethefilm.com/",
        urls: ["https://www.facebook.com/UnlockingTheCageFilm"],
        submission_status: "approved",
      },
      { name: "Sea of Shadows", urls: [], submission_status: "approved" },
      {
        name: "Inside Fur",
        url: "http://www.insidefur.com/",
        urls: [""],
        submission_status: "approved",
      },
      {
        name: "If a Tree Falls",
        url: "",
        urls: [
          "https://tubitv.com/movies/513826/if_a_tree_falls_a_story_of_the_earth_liberation_front",
        ],
        submission_status: "approved",
      },
      {
        name: "Animal Clock",
        url: "https://animalclock.org/",
        author: "",
        description:
          '"Animal Clock was created to bring attention to the incredible number of animals currently suffering on factory farms."',
        type: "website",
        email: "contact@animalclock.org",
        urls: ["https://twitter.com/animal_clock"],
        submission_status: "approved",
      },
      {
        name: "Called to Rescue",
        url: "https://www.calledtorescuefilm.com/",
        author: "",
        description:
          '"A beautiful and inspiring glimpse into the unbridled compassion on fifteen farm animal sanctuaries throughout the US. The rescued farm animals, simply by being who they are, are changing lives, lifestyles, and beliefs on both sides of the fence. The humans, many of whom dramatically altered the course of their lives because of a connection with a farm animal, are dedicated beyond words."',
        type: "documentary",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Challenge 22",
        url: "https://challenge22.com/",
        author: "",
        description:
          '"Are you ready for the challenge? Join thousands of participants for a 22-day vegan experience. You\'ll receive fabulous recipes and personal guidance from our mentors and clinical dietitians."',
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "ChooseVeg",
        url: "http://www.chooseveg.com/",
        author: "",
        description:
          "A website with helpful information on plant-based eating.",
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Counting Animals",
        url: "http://www.countinganimals.com/",
        author: "Harish",
        description:
          '"It is a blog that aims to collect, generate, analyze, organize, present and interpret quantitative information related to the animal advocacy movement. Occasionally, it will employ tools and insights from computer science and mathematics to discover facts pertinent to the animal advocacy movement. From time to time, it may also make number-related nerdy observations of no use to anybody."',
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Dairy is Scary",
        url: "https://www.youtube.com/watch?v=UcN7SGGoCNI",
        author: "Erin Janus",
        description: "",
        type: "video",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Eating You Alive",
        url: "https://www.eatingyoualive.com/",
        author: "",
        description: "",
        type: "documentary",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Food Choices",
        url: "http://www.foodchoicesmovie.com/",
        author: "",
        description: "",
        type: "documentary",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Food Monster",
        url: "https://www.onegreenplanet.org/foodmonsterapp/",
        author: "",
        description:
          '(iOS only) "One Green Planet\'s Food Monster app gives you instant access to vegan, meatless and dairy-free recipes that are sure to satisfy all taste buds! By SUBSCRIBING to our PAID monthly and yearly subscription options you can get access to 10+ new recipes DAILY (that’s an additional 3,000 new recipes every year!) but you can also unlock our archive of over 8,000 recipes searchable via 600+ category filters!"',
        type: "app",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Amazing Vegan Outreach - Videos",
        url: "https://www.amazingveganoutreach.com/videos",
        description: "",
        author: "Alex Bez",
        type: "video",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "List of Animal Sanctuarires",
        url: "https://www.vegan.com/sanctuaries/",
        description: "",
        author: "Vegan.com",
        type: "article",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "FoodPrint",
        url: "https://foodprint.org/",
        author: "",
        description:
          '"FoodPrint will help you make food choices that do less harm to the environment, animals and people."',
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Free From Harm",
        url: "https://freefromharm.org/",
        author: "",
        description: "",
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Go Vegan World",
        url: "https://goveganworld.com/",
        author: "",
        description:
          '"Go Vegan World exists to educate the public on animal rights, to promote veganism, to dispel the myths that sustain animal exploitation, and to dismantle the legal property status of other animals."',
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "How Not to Die",
        url: "https://nutritionfacts.org/book/",
        author: "Michael Greger, M.D.",
        description:
          '"From the physician behind the trusted website NutritionFacts.org, How Not to Die reveals the groundbreaking scientific evidence behind the only diet that can prevent and reverse many of the causes of premature death and disability"',
        type: "book",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "HowDoIGoVegan.com",
        url: "http://www.howdoigovegan.com/",
        author: "",
        description: "",
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "List of Vegans - Wikipedia",
        url: "https://en.wikipedia.org/wiki/List_of_vegans",
        author: "Various",
        description: "A list of noteworthy vegans throughout history.",
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Live Kindly",
        url: "https://www.livekindly.co/",
        author: "",
        description:
          '"Inspired by the notion that Mother Nature\'s intricate design is arguably flawless, the LK community have come together to build a home for informative and thought-provoking content, focusing on sustainable and compassionate living."',
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Lucent",
        url: "https://www.aussiepigs.com/lucent",
        author: "",
        description: "",
        type: "documentary",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "New Vegan Support",
        url: "https://www.facebook.com/groups/support4newvegans/",
        author: "",
        description: "a facebook group providing support for new vegans.",
        type: "community",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "NutritionFacts.org",
        url: "https://nutritionfacts.org/",
        author: "",
        description: "information about nutrition and health",
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Okja",
        url: "https://www.netflix.com/title/80091936",
        author: "",
        description: "",
        type: "film",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Bold Native",
        url: "https://www.imdb.com/title/tt1328908/",
        author: "Writer & Director: Denis Henry Hennelly",
        description: "",
        type: "film",
        urls: ["https://vimeo.com/171127429"],
        submission_status: "approved",
      },
      {
        name: "List of Vegan Media - Wikipedia",
        url: "https://en.wikipedia.org/wiki/List_of_vegan_media",
        author: "",
        description: "",
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "One Green Planet",
        url: "https://www.onegreenplanet.org",
        author: "",
        description:
          '"One Green Planet is a platform for the growing compassionate and eco-conscious generation. Our goal is to help create a world where we eat delicious food and use amazing products that provide us with maximum benefit and have minimum impact on the planet."',
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Peaceable Kingdom: The Journey Home",
        url: "http://www.peaceablekingdomfilm.org/",
        author: "Tribe of Heart",
        description:
          '"A riveting story of transformation and healing, PEACEABLE KINGDOM: THE JOURNEY HOME explores the awakening conscience of several people who grew up in traditional farming culture and who have now come to question the basic assumptions of their way of life."',
        type: "documentary",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Plant-Based News",
        url: "https://www.plantbasednews.org/",
        author: "",
        description:
          '"Plant Based News is a multi-award-winning resource for the latest up-to-the-minute plant-based-interest content. It is stuffed with vegan news, blogs, reviews, and much more. Our aim is to raise awareness about the climate crisis, environmentalism, animal rights, ethical consumerism and healthy plant-based living. Not a false narrative - but information that empowers people to make better choices."',
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Shrink That Footprint",
        url: "http://shrinkthatfootprint.com/",
        author: "",
        description:
          "A blog and video series about climate change and ways to reduce your carbon footprint",
        type: "information",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Slaughterhouse",
        url: "http://traslosmuros.com/en/slaughterhouses-investigation-mexico.php",
        author: "Tras los Muros",
        description:
          '"Over the course of a number of months, between the years 2015 and 2017 I gained access to 58 slaughterhouses, located ten different Mexican states. During this time, I documented the killing of cows, goats, chickens and horses, as well as the transport of these animals, from farm to slaughterhouse."',
        type: "documentary",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "The Best Speech You Will Ever Hear",
        url: "https://www.youtube.com/watch?v=U5hGQDLprA8",
        author: "Gary Yourofsky",
        description: "",
        type: "video",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "The China Study",
        url: "https://www.benbellavegan.com/book/the-china-study/",
        author: "T. Colin Campbell, Ph.D. and Thomas M. Campbell II, M.D.",
        description: "",
        type: "book",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "The Excuses Speech",
        url: "https://www.youtube.com/watch?v=oHfVajDbyJk",
        author: "Gary Yourofsky",
        description: "",
        type: "video",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "The Ghosts In Our Machine",
        url: "https://www.theghostsinourmachine.com/",
        author: "",
        description: "",
        type: "documentary",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "The Vegan Calculator",
        url: "https://thevegancalculator.com/",
        author: "",
        description: "",
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "The Vegan Rainbow Project",
        url: "http://www.the-vegan-rainbow-project.org/",
        author: "",
        description:
          '"With this blog we want to explore interconnections of oppression and enhance visibility for vegan living minorities and marginalised groups, whilst at the same time joining forces to work towards liberation for all beings."',
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "The World Peace Diet",
        url: "http://www.worldpeacediet.com/",
        author: "Dr. Will Tuttle PhD",
        description:
          '"The World Peace Diet, now translated and published worldwide in 16 languages, connects many dots—culturally, historically, nutritionally, ecologically, psychologically, and spiritually—to reveal how our routine exploitation of animals for food and other products boomerangs in countless ways, affecting both our outer world and the inner landscape of our daily experience."',
        type: "book",
        urls: [
          "https://www.facebook.com/WorldPeaceDiet/",
          "https://www.youtube.com/user/3739527/playlists",
          "https://twitter.com/WillTuttlePhD",
        ],
        submission_status: "approved",
      },
      {
        name: "This Speech Is Your Wake Up Call",
        url: "https://www.youtube.com/watch?v=KHOcox2lvQo",
        author: "James Aspey",
        description: "",
        type: "video",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "VeganActivism.org",
        url: "https://veganactivism.org/",
        author: "",
        description: "",
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "VeGuide",
        url: "https://www.vegansociety.com/go-vegan/veguide",
        author: "The Vegan Society",
        description: "A free app to help people go vegan.",
        type: "app",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "What the Health",
        url: "http://www.whatthehealthfilm.com/",
        author: "",
        description:
          '"What the Health is the groundbreaking follow-up film from the creators of the award-winning documentary Cowspiracy. The film exposes the collusion and corruption in government and big business that is costing us trillions of healthcare dollars, and keeping us sick."',
        type: "documentary",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "You Are Their Voice",
        url: "https://youaretheirvoice.com/",
        author: "",
        description:
          '"Vegan Developers & Designers Activists volunteering our time towards Vegan projects worth supporting 🐷"',
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "You Will Never Look at Your Life in the Same Way Again",
        url: "https://www.youtube.com/watch?v=Z3u7hXpOm58",
        author: "Earthling Ed",
        description:
          '"Watch the eye-opening speech that was given to thousands of students in universities across the UK."',
        type: "video",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Vegan Health",
        url: "https://veganhealth.org/",
        author: "",
        description:
          "VeganHealth.org provides:<br/>- Reviews of the scientific literature related to the health benefits of a vegan diet.<br/>- Discussions about concerns related to vegan nutrition.<br/>- Recommendations for nutrients that can be low in the diets of some vegans.",
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Double Check Vegan",
        url: "https://doublecheckvegan.com/",
        author: "",
        description: "Check whether ingredients are vegan or not.",
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Vegan Bootcamp",
        url: "https://veganbootcamp.org/",
        author: "",
        description: "",
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Vegan Playlist",
        url: "https://veganplaylist.org/",
        author: "",
        description:
          '"Find and share inspirational Vegan videos. Spread the compassionate Vegan message with our curated playlists, or create your own from our huge video library."',
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Kinder World",
        url: "https://www.kinderworld.org/",
        author: "",
        description: "",
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "The Dodo",
        url: "https://www.thedodo.com/",
        author: "",
        description: "",
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "TalkVegantoMe",
        url: "https://talkveganto.me/en/splash/",
        author: "",
        description: "",
        type: "app",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "HappyCow",
        url: "https://www.happycow.net/mobile",
        author: "",
        description: "",
        type: "app",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "The Animal People",
        url: "https://www.imdb.com/title/tt2337280/",
        author: "Executive Produced by Joaquin Phoenix",
        description:
          '"More than ten years in the making, the feature documentary THE ANIMAL PEOPLE, from directors Cassandra Suchan and Denis Henry Hennelly, follows the journey of six young activists who find themselves indicted as terrorists by the United States government. The reason for indictment: the activists\' leadership of a controversial open protest campaign aiming to close down the largest animal testing laboratory in the world."',
        type: "documentary",
        urls: [
          "https://www.facebook.com/theanimalpeopledoc/",
          "https://www.instagram.com/theanimalpeopledoc/",
        ],
        submission_status: "approved",
      },
      {
        name: "Animal Liberation",
        url: "https://www.goodreads.com/book/show/29380.Animal_Liberation",
        author: "Peter Singer",
        description:
          '"Since its original publication in 1975, this groundbreaking work has awakened millions of concerned men and women to the shocking abuse of animals everywhere -- inspiring a worldwide movement to eliminate much of the cruel and unnecessary laboratory animal experimentation of years past."',
        type: "book",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Why We Love Dogs, Eat Pigs, and Wear Cows: An Introduction to Carnism",
        url: "https://carnism.org/book/why-we-love-dogs-eat-pigs-and-wear-cows/",
        author: "Melanie Joy",
        description: "",
        type: "book",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Vystopia: The Anguish of Being Vegan in a Non-vegan World",
        url: "https://vystopia.com/",
        author: "Clare Mann",
        description: "",
        type: "book",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "Barnivore",
        url: "http://www.barnivore.com/",
        author: "",
        description:
          '"Is your booze vegan? It might seem weird at first, but your favourite drink might have more than just alcohol in it. The Barnivore Vegan Alcohol Directory is here to help."',
        type: "website",
        urls: [],
        submission_status: "approved",
      },
      {
        name: "The Game Changers",
        url: "https://gamechangersmovie.com/",
        author: "",
        description: "",
        type: "documentary",
        urls: [],
      },
      {
        name: "Animal Activist Support Line",
        url: "https://www.idausa.org/campaign/sustainable-activism/animal-activist-helpline/",
        author: "In Defense of Animals",
        description:
          '"We can provide you with free and confidential support on any aspect of your animal advocacy. We hope to hear from you soon!"',
        type: "website",
        urls: [],
      },
    ],
  }),
  methods: {
    findIconForUrl: function (url) {
      if (url.includes("facebook")) {
        return "mdi-facebook";
      } else if (url.includes("instagram")) {
        return "mdi-instagram";
      } else if (url.includes("twitter")) {
        return "mdi-twitter";
      } else if (url.includes("youtube")) {
        return "mdi-youtube";
      } else if (url.includes("meetup")) {
        return "mdi-alpha-m";
      } else {
        return "mdi-web";
      }
    },
  },
  computed: {
    filteredResources: function () {
      let resources = this.resources.slice();
      resources = resources.filter((e) => {
        return e.submission_status == "approved";
      });
      if (this.selected_resource_type != null) {
        resources = resources.filter((e) => {
          return e.type == this.selected_resource_type;
        });
      }
      resources.sort((a, b) => {
        return a.name.localeCompare(b.name);
      });
      return resources;
    },
  },
  filters: {
    capitalize: function (value) {
      if (!value) return "";
      value = value.toString();
      return value.charAt(0).toUpperCase() + value.slice(1);
    },
  },
};
</script>
