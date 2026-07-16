<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>#FurFreePDX</title>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <link href="https://unpkg.com/normalize.css@8.0.1/normalize.css" rel="stylesheet"/>


    <!-- Fonts -->
    <!-- <link href="https://db.onlinewebfonts.com/c/d60b13a925ef3dfc380e1dcd4cc5673b?family=IndustryIncW00-Base" rel="stylesheet" type="text/css"/> -->
    <!-- <link href="https://db.onlinewebfonts.com/c/a5639cd27a5f27e8be51b04ba9d92c09?family=IndustryIncW00-Inline" rel="stylesheet" type="text/css"/> -->
    <style>
      @font-face {font-family: "industry-inc-inline";
        src: url("./fonts/industry-inc-inline.eot");
        src: url("./fonts/industry-inc-inline.eot") format("embedded-opentype"),
        url("./fonts/industry-inc-inline.woff2") format("woff2"),
        url("./fonts/industry-inc-inline.woff") format("woff"),
        url("./fonts/industry-inc-inline.ttf") format("truetype"),
        url("./fonts/industry-inc-inline.svg") format("svg");
      }
      @font-face {font-family: "industry-inc-base";
        src: url("./fonts/industry-inc-base.eot");
        src: url("./fonts/industry-inc-base.eot") format("embedded-opentype"),
        url("./fonts/industry-inc-base.woff2") format("woff2"),
        url("./fonts/industry-inc-base.woff") format("woff"),
        url("./fonts/industry-inc-base.ttf") format("truetype"),
        url("./fonts/industry-inc-base.svg") format("svg");
      }
    </style>



    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet"/>

    <!-- Materialize -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
      html, body {
        margin:0;
        padding:0;
        font-family: 'Josephin Sans', sans-serif;
      }
      * {
        box-sizing:border-box;
      }
      header {
        position:relative;
        font-family: "industry-inc-inline";
        background-color: #91eeff;
        color:white;
        z-index:10;
        text-align:center;
        padding:10px;
      }
      header a {
        font-size:50px;
        color:white;
      }
      .sidenav-trigger {
        margin-left:10px;
        position:sticky;
        position: -webkit-sticky;
        top:0;
        display:block;
      }
      .sidenav-trigger i {
        font-size:40px;
      }
      @media (max-width:800px) {
        header a {
          font-size:30px;
        }
        .sidenav-trigger {
          position:relative;
          width:10px;
        }
        .sidenav-trigger i {
          font-size:20px;
        }
      }
      hr {
        color:white;
        background-color:lightgrey;
      }
    </style>
  </head>
  <body>
    <header>
      <a href="#" data-target="slide-out" class="sidenav-trigger left"><i class="material-icons">menu</i></a>
      <a href="/">#FurFreePDX</a>
    </header>
    <ul id="slide-out" class="sidenav">
      <li><a href="/">Home</a></li>
      <li><a href="why_ban_fur.php">Why Ban Fur?</a></li>
      <li><a href="commissioners.php">Take Action</a></li>
      <li><a href="petition_locations.php">Petition Locations</a></li>
      <li><a href="endorsement_letter.php">Endorsement Letter</a></li>
      <li><a href="model_legislation.php">Model Legislation</a></li>
      <li><a href="https://compassionatecity.org/">Compassionate Cities</a></li>
      <li><a href="about_us.php">About us</a></li>
    </ul>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.sidenav');
        var instances = M.Sidenav.init(elems, {});
      });
    </script>
