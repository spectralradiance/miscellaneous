<template>
  <!-- https://thevegancalculator.com/#calculator -->
  <v-container class="center">
    <v-tabs centered>
      <v-tab href="#saved">Saved</v-tab>
      <v-tab href="#lost">Lost</v-tab>
      <v-tab-item value="saved">
        <h1 class="calculator_title">How long have you been vegan?</h1>
        <hr />
        <v-row align="center">
          <v-spacer></v-spacer>


          <v-col cols="12" md="4">
            <v-subheader class="pl-0">
              Decades: {{input_decades}}
            </v-subheader>
            <v-slider
              v-model="input_decades"
              min="0"
              max="10"
            ></v-slider>
          </v-col>

          <v-col cols="12" md="4">
            <v-subheader class="pl-0">
              Years: {{input_years}}
            </v-subheader>
            <v-slider
              v-model="input_years"
              min="0"
              max="10"
            ></v-slider>
          </v-col>

          <v-col cols="12" md="4">
            <v-subheader class="pl-0">
              Months: {{input_months}}
            </v-subheader>
            <v-slider
              v-model="input_months"
              min="0"
              max="12"
            ></v-slider>
          </v-col>

          <v-col cols="12" md="9">
            <v-subheader class="pl-0">
              Days: {{input_days}}
            </v-subheader>
            <v-slider
              v-model="input_days"
              min="0"
              max="31"
            ></v-slider>
          </v-col>

          <v-col cols="12" md="3">
            <v-radio-group v-model="input_units">
              <v-radio label="Metric" value="metric"></v-radio>
              <v-radio label="Imperial" value="imperial"></v-radio>
            </v-radio-group>
          </v-col>

          <v-spacer></v-spacer>
        </v-row>
        <h1>You've saved...</h1>
        <hr />
        <div v-for="(rate, i) in rates" :key="i" class="rate">
          <v-icon size="60">{{ rate.icon }}</v-icon>
          <span>{{ calculateRate(rate) }} {{ rate[input_units].units }}</span>
        </div>
      </v-tab-item>
      <v-tab-item value="lost">
        <div class="lost_title">
          Listed below are the number of animals killed by humans since you
          opened this page,
          {{ Math.floor(milliseconds_since_open / 1000) }} seconds ago
        </div>
        <v-row v-for="(rate, i) in death_rates" :key="i">
          <v-col class="text-right">{{ rate.name }}</v-col>
          <v-col>{{ formatNumber(rate.total_since_open) }}</v-col>
        </v-row>
      </v-tab-item>
    </v-tabs>
  </v-container>
</template>
<style>
.rate {
  font-size: 2rem;
}
.rate span {
  margin-left: 20px;
}
.center {
  max-width: 600px;
  margin: 0 auto;
}
.switch_entry i {
  transform: scaleY(-1) translateY(25%);
}
.switch_entry {
  padding: 10px 0;
  user-select: none;
}
.calculator_title {
  padding: 20px 0;
}
.lost_title {
  font-size: 1.4rem;
  margin: 20px;
}
.theme--dark.v-tabs > .v-tabs-bar {
  background-color: transparent;
}
.theme--dark.v-tabs-items {
  background-color: transparent;
}
</style>
<script>
export default {
  name: "Calculator",
  data: () => ({
    modal: false,
    input_date: null,
    input_decades: 0,
    input_years: 0,
    input_months: 0,
    input_days: 1,
    input_units: "metric",
    rates: [
      {
        name: "water",
        icon: "mdi-water",
        metric: {
          rate: 4163.9,
          units: "litres of water",
        },
        imperial: {
          rate: 1100,
          units: "gallons of water",
        },
      },
      {
        name: "grain",
        icon: "mdi-barley",
        metric: {
          rate: 18.1,
          units: "kg of grain",
        },
        imperial: {
          rate: 40,
          units: "lbs of grain",
        },
      },
      {
        name: "forest",
        icon: "mdi-pine-tree",
        metric: {
          rate: 2.8,
          units: "square meters of forest",
        },
        imperial: {
          rate: 30,
          units: "square feet of forest",
        },
      },
      {
        name: "co2",
        icon: "mdi-cloud",
        metric: {
          rate: 9.1,
          units: "kg of CO2",
        },
        imperial: {
          rate: 20,
          units: "lbs of CO2",
        },
      },
      {
        name: "animals",
        icon: "mdi-cow",
        metric: {
          rate: 1,
          units: "animal lives",
        },
        imperial: {
          rate: 1,
          units: "animal lives",
        },
      },
    ],
    death_rates: [
      {
        name: "marine animals",
        rate_million_year: 90000,
      },
      {
        name: "chickens",
        rate_million_year: 45895,
      },
      {
        name: "ducks",
        rate_million_year: 2262,
      },
      {
        name: "pigs",
        rate_million_year: 1244,
      },
      {
        name: "rabbits",
        rate_million_year: 857,
      },
      {
        name: "turkeys",
        rate_million_year: 691,
      },
      {
        name: "geese",
        rate_million_year: 533,
      },
      {
        name: "sheep",
        rate_million_year: 515,
      },
      {
        name: "goats",
        rate_million_year: 345,
      },
      {
        name: "cows and calves",
        rate_million_year: 292,
      },
      {
        name: "rodents",
        rate_million_year: 65,
      },
      {
        name: "pigeons and other birds",
        rate_million_year: 63,
      },
      {
        name: "buffaloes",
        rate_million_year: 23,
      },
      {
        name: "dogs",
        rate_million_year: 16,
      },
      {
        name: "cats",
        rate_million_year: 4,
      },
      {
        name: "horses",
        rate_million_year: 4,
      },
      {
        name: "donkeys and mules",
        rate_million_year: 3,
      },
      {
        name: "camels and other camelids",
        rate_million_year: 2,
      },
    ],
    open_date: null,
    milliseconds_since_open: 0,
    sources: [
      {
        name: "",
      },
    ],
  }),
  methods: {
    calculateRate: function (rate) {
      let total_days =
        parseInt(this.input_decades) * 365 * 10 +
        parseInt(this.input_years) * 365 +
        parseInt(this.input_months) * 30 +
        parseInt(this.input_days);
      let v = total_days * rate[this.input_units].rate;
      v = v.toPrecision(3); // reduce to 2 significant figures
      v = parseFloat(v); // remove scientific notation
      v = v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); // add commas
      return v;
    },
    updateTotal: function () {
      window.requestAnimationFrame(this.updateTotal);
      this.milliseconds_since_open =
        new Date().getTime() - this.open_date.getTime();

      this.death_rates.forEach((rate) => {
        rate.total_since_open =
          rate.rate_millisecond * this.milliseconds_since_open;
      });
      this.$forceUpdate();
    },
    formatNumber: function (num) {
      return Math.floor(num)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
  },
  created: function () {
    this.death_rates.forEach((rate) => {
      rate.rate_million_year *= 1000000;
      rate.rate_millisecond =
        rate.rate_million_year / 365 / 24 / 60 / 60 / 1000;
      rate.total_since_open = 0;
    });
    this.open_date = new Date();
    window.requestAnimationFrame(this.updateTotal);
  },
};
</script>
