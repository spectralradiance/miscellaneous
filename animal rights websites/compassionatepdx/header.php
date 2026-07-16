<!DOCTYPE html>
<html lang="en" class="<?php echo 'theme' . htmlspecialchars($_GET["theme"] ?? '1');?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compassionate PDX</title>

    <link rel="shortcut icon" href="/content/icons/favicon.ico"/>
    <meta name="description" content="Compassionate PDX is a grass-roots group of volunteers advocating for non-human animals." />
    <meta property="og:image" content="/content/icons/icon1_orange.png" />
    <meta property="og:site_name" content="compassionatepdx.org" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!-- Materialize -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Roboto Slab -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet"> -->
    <!-- Open Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,700;1,400&display=swap" rel="stylesheet"> -->

    <!-- Vue -->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

    <style>

        .theme1 {
            /* --footer-main: CORNFLOWERBLUE;
            --footer-social: ROYALBLUE; */

            --footer-main-foreground: white;
            --footer-main-background: #455a64;
            --footer-social: #37474f;

            --button-background: #ff9800;
            --card-background: #455a64;
            --card-foreground: white;
            --card-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 3px 1px -2px rgba(0,0,0,0.12), 0 1px 5px 0 rgba(0,0,0,0.2);
            --card-border: none;
        }

        .theme2 {

            --footer-main-foreground: black;
            --footer-main-background: beige;
            --footer-social: #593414;

            --button-background: #F29727;
            --card-background: white;
            --card-foreground: black;
            --card-shadow: none;
            --card-border: none;
        }

        label {
            color: white !important;
        }

         /* label focus color */
        .input-field input[type=text]:focus + label {
            color: white !important;
        }
        /* label underline focus color */
        .input-field input[type=text]:focus {
            border-bottom: 1px solid white !important;
            box-shadow: 0 1px 0 0 white !important;
        }

        .btn {
            background-color:  var(--button-background) !important;
        }


        html {
            scroll-behavior: smooth;
            box-sizing: border-box;
        }
        html, body, #page {
            min-height:100vh;
        }
        body {
            background-color:white;
            
            font-family: 'Open Sans', sans-serif;
        }
        nav ul a {
            font-size:1.2rem;
            transition: all 1s;
        }
        nav ul a:hover {
            background-color:rgba(0,0,0,0.7)
        }
        /* .nav-wrapper:hover {
            background-color:rgba(0,0,0,0.7) !important;
        } */

        nav {
            
            /* padding: 0 20px; */
            z-index:10;
            height: initial !important;
            /* text-shadow: -1px -1px 10px #000, 1px -1px 10px #000, -1px 1px 10px #000, 1px 1px 10px #000; */
            /* text-shadow: -1px -1px 20px #111, 1px -1px 20px #111, -1px 1px 20px #111, 1px 1px 20px #111; */

        }
        
        .nav-wrapper {
            background-color:rgba(0,0,0, 0.5);
            border-bottom: 1px solid rgba(0,0,0,0.5);
        }
        
        .nav-wrapper .container {
            display: flex;
            flex-direction: row;
            justify-content:space-between;
            align-items:stretch;
        }
        nav .brand-logo {
            position: static;
        }
        nav ul, .title_icon {
            display: flex;
            flex-direction: row;
            align-items:stretch;
        }
        .brand-logo {
            line-height: 76px;
        }
        nav ul a {
            display:block;
            /* height:100%; */
            line-height: 76px;
        }
        /* nav li a:hover {
            color: #ffc107;
            font-size:20px;
        } */
        .nav-wrapper {
            /* font-family: 'Roboto Slab', serif; */
            transition: all 1s;
            /* padding: 0 20px; */
            
        }
        nav {
            padding-bottom:20px;
        }
        nav h2 {
            margin: 40px 0;

        }
        nav img {
            height:40px;
            margin: auto 10px;
        }
        .brand-logo {
            white-space:nowrap;
        }
        #page {
            /* max-width:1000px; */
            margin:0 auto;
            background-color:white;
        }
        .page-title {
            clear:both;
        }
        .sidenav-trigger, .sidenav-trigger i {
            display:inline-block;
            height: 76px !important;
            margin: 10px 0;
        }
        @media only screen and (max-width: 992px) {
            nav .brand-logo {
                left: 0 !important;
                -webkit-transform:none;
                transform:none;
            }
            nav .sidenav-trigger {
                margin: 0 !important;
            }
        }
        .header_image_credit {
            /* display:block; */
            position:absolute;
            transform:translateY(-40%);
            right:10px;
            font-size:10px;
            opacity:0.5;
        }

        .subtitle {
            line-height:normal!important;
            font-size:1.25rem;
            margin-top:20px;
            max-width:600px;
        }
    </style>
</head>
<body>
    <ul id="slide-out" class="sidenav">
        <li><a href="/furtruth.php">The Truth about Fur</a></li>
        <li><a href="/furfreepdx">Fur Free PDX</a></li>
        <li><a href="/furfreeoregon.php">Fur Free Oregon</a></li>
        <!-- <li><a href="#!"><i class="material-icons">cloud</i>First Link With Icon</a></li>
        <li><a href="#!">Second Link</a></li>
        <li><div class="divider"></div></li>
        <li><a class="subheader">Subheader</a></li>
        <li><a class="waves-effect" href="#!">Third Link With Waves</a></li> -->
    </ul>
    <div id="page">
        <nav>
            <div class="inner-nav">
                <div class="nav-wrapper">
                    <div class="container">
                        <div class="title_icon">
                            <img src="/content/icons/icon1_white_punchout.png" class="hide-on-small-only" />
                            <a href="/" class="brand-logo">Compassionate PDX</a>
                        </div>
                        <ul id="nav-mobile" class="hide-on-med-and-down">
                            <li><a href="/furtruth.php">The Truth about Fur</a></li>
                            <li><a href="/furfreepdx">Fur Free PDX</a></li>
                            <li><a href="/furfreeoregon.php">Fur Free Oregon</a></li>
                            <!-- <li><a href="/furfreeoregon.php">Fur Facts</a></li> -->
                            <!-- <li><a href="/furfreeoregon.php">Coalition</a></li> -->
                            <!-- <li><a class="dropdown-trigger" href="#!" data-target="dropdown1">Campaigns<i class="material-icons right">arrow_drop_down</i></a></li> -->
                        </ul>
                        <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                    </div>
                </div>
            
                <div class="page-title container">
                    <?php echo $title; ?>
                </div>
            </div>
            <a class="header_image_credit" href="<?php echo $header_image_credit_url; ?>"><?php echo $header_image_credit_text; ?></a>
        </nav>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var elems = document.querySelectorAll('.sidenav');
                var instances = M.Sidenav.init(elems, {
                    edge: 'right'
                });

                var dropdown_elems = document.querySelectorAll('.dropdown-trigger');
                var dropdown_instances = M.Dropdown.init(dropdown_elems, {
                    constrainWidth: false,
                    coverTrigger: false
                });
            });
        </script>