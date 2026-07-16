# arc
> animal rights collective; a reproducible web application for enabling animal rights activism
https://arcpdx.org/

## Testing & Deploying

- Clone from GitHub `git clone `
- Move in the the project directory
- Install packages `npm install`
- Run in development with `npm run serve`
- Deploy with `npm run build` followed by `firebase deploy`


- [firebase docs on deploying](https://firebase.google.com/docs/hosting)

## Features


- events
- groups
  - organizations
  - communities
  - sanctuaries
- resources


## Todo

- homepage
  - photos
  - latest voices for the animals
  - organization/resource/response of the day
- calculator
  - resources saved - add sliders, sources
  - deaths
    - icon for each species
    - counter - add reset button, sources, images for each species
    - [data table](https://vuetifyjs.com/en/components/data-tables/) from [jfa data](https://justiceforanimals.org/Table:_Annual_Slaughter_Counts_of_Land_Animals_by_Country,_Animal,_and_Usage) with [frozen row/coumn](https://codepen.io/lzhoucs/pen/dqZvXr?editors=0010) - view by country, industry, timescale (per second, per minute, per hour, per day, per month, per day)
    - [map](https://plotly.com/javascript/choropleth-maps/)
- events
  - properly format the event datetimes using [moment.js](https://www.npmjs.com/package/vue-moment)
  - [calendar](https://vuetifyjs.com/en/components/calendars/) view
- share button on every item and every page
  - share to facebook, twitter, instagram
  - copy text
  - copy link
- organizations - filter by local / national / online
- online actions
  - check off one at a time, save with user, counter for completed items
- newsletter on MailChimp
- data
  - groups
    - restaurants
    - businesses
  - articles
    - dairy
    - environmentalism
    - famous vegans
    - get active
      - online activism
      - stickers
      - mentorship programs
    - go vegan
      - -> plant-based brands
      - mentorship programs
    - humane
    - intersectionality
    - nutrition
    - plant-based brands
      - daiya, oatly
    - statistics
    - veganism
  - resources
    - documentaries
    - websites
  - search
  - list of all organizations
- api?
- apps
  - calculator for resources saved since going vegan
  - death clock / counter
  - meal builder, show nutrition information
  - sources of various nutrients and the amount
  - weather
  - calendar (weather, holidays, events)


## Data Sources

- [holidays](http://www.holidays-and-observances.com/animal-holidays.html)
- 