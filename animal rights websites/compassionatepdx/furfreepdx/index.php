
<?php ob_start(); ?>
<h2><strong>Fur Free PDX<strong></h2>
<div class="subtitle">Portland is a leader in progressive ethics, we're a city that values compassion and respects life. Together we help end the cruel treatment of fur-bearing animals.</div>
<a class="btn" href="">Buy a Shirt</a>
<?php
$title = ob_get_clean();
$header_image_credit_text = '';
$header_image_credit_url = '';
?>

<?php
include('../header.php');
?>

<style>
    /* nav {
        background: linear-gradient(rgba(0,0,0,.3), rgba(0,0,0,.3)), url('../content/headers/mink2.jpg');
        background-position:20% 62%;
        background-size: 110%;
    } */

    nav {
        background: linear-gradient(rgba(0,0,0,.3), rgba(0,0,0,.3)), url('../content/headers/fox1.jpg');
        background-position:20% 50%;
        background-size: cover;
        background-color:black;
        background-repeat:no-repeat;
    }
    
</style>


<style>
  #section3 h2 {
    margin-top:0;
    text-align:left;
  }
  #section3 p {
    text-align:left;
  }
  .indicators, .content-indicator {
    background-color: rgba(0,0,0,0.5)
  }
  .indicators {
    /* height:60px; */
  }
  /* .carousel {
    height:300px !important;
  } */


</style>

<style>
  .modal-header {
    display:flex;
    flex-direction:row;
    justify-content: space-between;
  }
  .modal-header a {
    position: relative;
    top:-10px;
    left:10px;
    font-size:20px;
  }
  .modal-content {
    height:auto !important;
  }

  #mc_embed_signup label {
    font-family: 'Josefin Sans', sans-serif;
  }

  .modal-header-text {
    /* font-family: 'Josefin Sans'; */
  }


  #section2 section p {
    font-size:20px;
  }


  .endorsement_container {
    display:flex;
    flex-direction:row;
    justify-content:center;
    align-items:center;
    flex-wrap:wrap;
    margin:0 auto;
    max-width:1000px;
  }
  .endorsement {
    margin:2px;
  }
  .endorsement img {
    width:86px;
    padding:6px;
    transition: all 200ms;
  }
  .endorsement img:hover {
    box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 3px 1px -2px rgba(0,0,0,0.12), 0 1px 5px 0 rgba(0,0,0,0.2);
    
  }
  section {
    padding:20px;
  }

  @media (max-width:800px) {
    #section2 {
      flex-direction:column;
      align-items:center;
    }
    #section2 section {
      width:80%;
      margin: 30px 0;
    }
    .modal-header-text {
      font-size:20px;
    }
    #section1 img {
      width:auto;
      height:100%;
      top:0;
      transform:none;
    }
    #section3 {
      flex-direction:column!important;
      align-items:center;
    }
  }
  /* img {
      max-width:100%;
  } */
  main h4 {
    background-color: var(--card-background);
    color: white;
    margin-bottom:30px;
    padding:30px;
    /* border-bottom: 2px solid #eceff1; */
    text-align:center;
    /* border-bottom:1px solid black; */
    box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 3px 1px -2px rgba(0,0,0,0.12), 0 1px 5px 0 rgba(0,0,0,0.2)
    
  }

  .middle-indicator {
      height:100%;
      padding:20px;
      display:flex;
      flex-direction:row;
      align-items:center;
      justify-content:space-between;
  }

  .middle-indicator-text {
      font-size: 3rem;
  }

  a.middle-indicator-text {
      color: white !important;
  }

  .content-indicator {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      text-align:center;
  }
  main {
    max-width:1000px;
    margin: 0 auto;
  }
  .img_header {
    margin:40px;
    text-align:center;
  }
  .img_header img {
    /* max-width:800px; */
    width:100%;
    box-shadow: 0 8px 17px 2px rgba(0,0,0,0.14), 0 3px 14px 2px rgba(0,0,0,0.12), 0 5px 5px -3px rgba(0,0,0,0.2)
  }


  #section3 li i {
    transition: all 200ms;
  }
  #section3 li.active i {
    -ms-transform: rotate(-180deg); /* IE 9 */
    -webkit-transform: rotate(-180deg); /* Chrome, Safari, Opera */
    transform: rotate(-180deg);
  }
  #section3 .collapsible-header {
    display:flex;
    flex-direction:row;
    justify-content:space-between;
    transition: all 200ms;
    margin-top:4px;
    /* background-color: #f5f5eb; */
    /* font-size:20px; */
  }
  #section3 .collapsible-header:hover, #section3 li.active .collapsible-header {
    background-color: #455a64 !important;
    color:white;
  }
</style>

<!-- <div class="img_header"><img src="/content/furfreepdx/ffpdx_header.jpg"/></div> -->


<main>
  <section id="section2">
    <h4><b>4800</b> Portland residents have signed the petition to ban the sale of new fur products.</h4>
    <div class="carousel carousel-slider center " data-indicators="true">
        <div class="carousel-fixed-item center middle-indicator">
            <div>
                <a href="#!"
                    class="movePrevCarousel middle-indicator-text waves-effect waves-light content-indicator"><i
                        class="material-icons left  middle-indicator-text">chevron_left</i></a>
            </div>

            <div>
                <a href="#!"
                    class=" moveNextCarousel  middle-indicator-text waves-effect waves-light content-indicator"><i
                        class="material-icons right middle-indicator-text">chevron_right</i></a>
            </div>
        </div>
        <div class="carousel-item white-text" href="#one!">
          <img src="../content/furfreepdx/signatures1.jpg">
        </div>
        <div class="carousel-item white-text" href="#two!">
          <img src="../content/furfreepdx/signatures2.jpg">
        </div>
        <div class="carousel-item white-text" href="#three!">
          <img src="../content/furfreepdx/signatures3.jpg">
        </div>
        <div class="carousel-item white-text" href="#four!">
          <img src="../content/furfreepdx/signatures4.jpg">
        </div>
    </div>
    <script>

$(document).ready(function () {
  
  // start carousel
  $('.carousel.carousel-slider').carousel({
    // fullWidth: true,
    indicators: false,
    // height: 0
  });
  
  
  // move next carousel
  $('.moveNextCarousel').click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    $('.carousel').carousel('next');
  });
  
  // move prev carousel
  $('.movePrevCarousel').click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    $('.carousel').carousel('prev');
  });
  
  
  // setInterval(function() {
    //   $('.carousel').carousel('next');
    // }, 3000)
  })
  </script>
  </section>

  <section id="section_logos">
    <h4>Over 50 Portland-based businesses have endorsed the ban on the sale of new fur products. <a href="" class="btn btn-small orange">Endorse</a>&nbsp;<a href="endorsements.php" class="btn btn-small orange">View Letter</a></h4>
    <div class="row center"></div>
    <div class="endorsement_container">
      <a v-for="endorsement in endorsements"
         v-if="endorsement.logo"
         class="endorsement"
         v-bind:href="endorsement.url"
         v-bind:title="endorsement.name"
         target="_blank">
        <img v-bind:src="'../content/furfreepdx/endorsement_logos/' + endorsement.logo"/>
      </a>
    </div>
    <br/>
    <h4>17 local, national, and international organizations are in our coalition</h4>
    <div class="endorsement_container">
      <a v-for="coalition_member in coalition"
         class="endorsement"
         v-bind:href="coalition_member.url"
         v-bind:title="coalition_member.name"
         target="_blank">
        <img v-bind:src="'../content/furfreepdx/endorsement_logos/' + coalition_member.logo"/>
      </a>
    </div>
  </section>

  
        
  <section id="section3">
      <h4>Fur Ban FAQ</h4>
      <ul class="collapsible popout">
        <li v-for="faq in faqs">
          <div class="collapsible-header">
            <span>{{faq.title}}</span>
            <i class="material-icons">expand_more</i>
          </div>
          <div class="collapsible-body">{{faq.text}}</div>
        </li>
      </ul>
  </section>

  <section>
    <h4>Model Legislation</h4>
    <div class="container">
      <p>Our model legislation is based on the ban that was passed in San Francisco. It is a city ordinance that prohibits the manufacture and sale of new fur products within city limits: fur coats, coats with fur trim, handbags, shoes, hats, and keychains. You can view the full text <a href="/content/furfreepdx/Portland Fur Ban Ordinance Draft.pdf">here</a>.</p>
      <ul class="browser-default">
        <li>6-month phase-in period for companies to sell current stock</li>
        <li>Does not cover the sale of used or vintage fur</li>
        <li>Does not prohibit people from wearing fur</li>
        <li>Does not cover the sale of fur from animals trapped within the state, which is managed by the Oregon Department of Fish and Wildlife</li>
        <li>Does not apply to indigenous people of the Americas for religious or cultural uses</li>
      </ul>
    </div>
  </section>

<div class="img_header"><img src="/content/furfreepdx/ffpdx_footer.jpg"/></div>

</main>

<script src="../content/furfreepdx/endorsements.js" type="text/javascript"></script>
<script>

$(document).ready(function(){
  $('.collapsible').collapsible();
})

// let carousel_elements = document.querySelectorAll('.carousel')
// let carousel_instances = M.Carousel.init(carousel_elements, {
  //   fullWidth: true,
  //   indicators: true
  // });
  // for (let i=0; i<carousel_elements.length; ++i) {
    //   let bt_prev = carousel_elements[i].querySelector('.bt_prev')
    //   let bt_next = carousel_elements[i].querySelector('.bt_next')
    //   bt_prev.onclick = function() {
      //     carousel_instances[i].prev()
      //   }
      //   bt_next.onclick = function() {
        //     carousel_instances[i].next()
        //   }
        // }


  let app = new Vue({
    el: '#section_logos',
    data: {
      coalition: endorsement_coalition,
      endorsements: endorsement_businesses
    }
  })

  let app2 = new Vue({
    el: '#section3',
    data: {
      faqs: [{
        title: 'What would the fur ban do?',
        text: 'This ordinance would prohibit the manufacture and sale of new fur products within the city of Portland. This includes (but is not limited to) coats with fur trim, handbags, shoes, hats, and key chains.'
      },{
        title: 'Why Portland?',
        text: 'Portland has long been a leader in enacting policies to help animals and the environment. It was an early adopter of the Bottle Bill, passed some of the nation’s most restrictive puppy mill laws in 2010, banned plastic bags in 2011, and just passed a strong law restricting single-use plastic. Joining other cities in prohibiting this archaic, cruel, and unnecessary product is in line with Portland’s progressive ethics.'
      },{
        title: 'Won\'t this hurt local business?',
        text: 'Most fur sold in Portland is imported from China or Canada. No businesses in Portland rely solely on the sale of fur and for those that do, it is a negligible amount of sales. However, in order to mitigate any economic impacts, there will likely be a one-year cushion after the ban takes effect to sell any fur products that they purchased prior to the ordinance adoption date.'
      },{
        title: 'What about the loss of taxes?',
        text: 'There is no sales tax in Oregon. This ban would have no impact on taxes.'
      },{
        title: 'Isn’t faux fur made from plastic and bad for the environment?',
        text: 'Faux fur can be made from recycled or biodegradable materials, or can simply be avoided. The fur industry contributes to water pollution through the discharge of nitrogen and phosphorous. Fur is processed with carcinogenic chemicals, including chromium and formaldehyde, which can damage human health and prevents it from being biodegradable. It takes fifteen times more energy to make a coat from animal fur than from faux fur.'
      },{
        title: 'Will people be banned from wearing fur?',
        text: 'No. The law only regulates the manufacture and sale of fur within the city of Portland.'
      },{
        title: 'What about the sale of “vintage” fur and used clothing? What about leather, etc?',
        text: 'The law only regulates the manufacture and sale of new fur items. Used fur items, as well as leather, cowhide and lambskin/sheepskin, even with hair attached are all exempt.'
      },{
        title: 'It can’t be done. The industry is too powerful.',
        text: 'Not true. West Hollywood banned the sale of fur in 2013 when fur sales were estimated at two million dollars annually. Four cities and counting have adopted similar bans, and a statewide fur ban bill is currently moving through the California State Assembly.'
      }]
    }
  })
</script>


<?php
include('../footer.php');
?>