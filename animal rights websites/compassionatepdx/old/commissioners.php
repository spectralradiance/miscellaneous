<?php
include('header.php');
?>

<style>
  .commissioner {
    margin:10px;
  }
  #app {
    max-width:600px;
    margin:0 auto;
    padding:10px;
  }
  h4 {
    text-align:center;
  }
</style>
<main id="app">
  <h4>Contact Your City Commissioners</h4>
  <p>The city commissioners are elected officials that represent the people of Portland. If you are a resident of Portland, <b>email</b> them and follow up with a <b>phone call</b> to let them know you support a ban on the sale of new fur products.</p>
  <hr/>
  <div v-for="commissioner in commissioners" class="commissioner">
    <h5>{{commissioner.name}}</h5>
    <div><b>Mail:</b> {{commissioner.address}}</div>
    <div><b>Email:</b> <a v-bind:href="'mailto:'+commissioner.email">{{commissioner.email}}</a></div>
    <div><b>Phone:</b> <a v-bind:href="'tel:'+commissioner.phone">{{commissioner.phone}}</a></div>
  </div>
</main>
<script>
  let app = new Vue({
    el: '#app',
    data: {
      commissioners: []
    }
  })
</script>

<?php
include('footer.php');
?>
