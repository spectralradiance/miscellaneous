
<?php ob_start(); ?>
<h2>Fur Free PDX</h2>
<p>Test</p>
<?php
$title = ob_get_clean();
?>

<?php
include('../header.php');
?>

<style>
    nav {
        background: linear-gradient(rgba(0,0,0,.3), rgba(0,0,0,.3)), url('../content/headers/mink2.jpg');
        background-position:20% 62%;
        background-size: 110%;
    }
</style>

<style>
  main {
    max-width:900px;
    margin:0 auto;
    font-size:18px;
    padding:10px;
  }
  li {
    margin:10px;
  }
  h4 {
    text-align:center;
  }
  .endorsement_container {
    display:flex;
    flex-direction:row;
    justify-content:center;
    align-items:center;
    flex-wrap:wrap;
    margin:0 auto;
    max-width:800px;
  }
  
  .endorsement_container div {
    width:200px;
    height:60px;
    margin:10px;
    
  }
</style>

<main>
  <h4>Portland-Based Businesses Support the Ban on Fur</h4>
  <hr/>
  <p>We, the undersigned Portland-based businesses in Portland urge you to support the initiative of Compassionate PDX to pass a ban on the manufacture and sale of fur in the city. This legislation would prohibit the manufacture and sale of certain kinds of fur products and uphold humane standards by protecting animals that suffer as a result of the inhumane fur industry. Similar laws have been passed in West Hollywood, Berkeley, San Francisco, and Los Angeles, and have also been introduced in New York City and the state of California.</p>
  <p>Most retailers in Portland do not sell fur products, and of the small number of retailers that do, it is only sold seasonally, and none of them rely solely on this product for their business to remain profitable. These retailers could easily switch to product lines carried by the same brands that simply do not come with animal fur attached, or switch to one of the many faux-fur options for customers who want the aesthetics of fur trim without the cruelty. </p>  
  <p>Fashion powerhouses such as Michael Kors, Versace, Chanel, Gucci, Donna Karan, Burberry and many more have dropped fur in recent years after learning about the cruelties involved, yet it is still not uncommon to see people walking around downtown Portland with coyote or fox-fur trimmed jackets or rabbit fur keychains. This law aims to protect not just animals but also consumers, since dozens of retailers have been caught selling dog and cat fur from China and few people who buy these items seem to know that wild coyotes are caught in steel traps, or rabbits are bludgeoned or skinned alive for these trinkets.</p>
  <p>There is so much violence in the world beyond our control, so let’s eliminate whatever cruelty we can, especially when it’s for something as unnecessary these days as fur. We strongly support Portland in joining several other cities, and many prominent retailers in ending the sale of fur.</p>
  <p>Sincerely,</p>
  <div class="endorsement_container">
  <div v-for="business in businesses">
     	• {{business.name}}
  </div>
  </div>
</main>



<script src="../content/furfreepdx/endorsements.js" type="text/javascript"></script>
<script type="text/javascript">
  let app = new Vue({
    el: 'main',
    data: {
      businesses: endorsement_businesses
    }
  })
</script>

<?php
include('../footer.php');
?>
