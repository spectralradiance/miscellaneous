<?php
include('header.php');
?>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<style>
  .endorsement_container {
    display:flex;
    flex-direction:row;
    justify-content:center;
    align-items:center;
    flex-wrap:wrap;
  }
  .endorsement {
    margin:20px;
  }
  .endorsement img {
    width:100px;
  }
  #app {
    max-width:600px;
    margin:0 auto;
    padding:10px;
  }
  #app h4 {
    text-align:center;
  }
</style>
<main id="app">
  <h4>Endorsements</h4>
  <div class="endorsement_container">
    <a v-for="endorsement in endorsements"
       class="endorsement"
       v-bind:href="endorsement.url"
       target="_blank">
      <img v-bind:src="'./content/endorsement_logos/' + endorsement.logo"/>
    </a>
  </div>
</main>
<script>
  let app = new Vue({
    el: '#app',
    data: {
      endorsements: []
    }
  })
</script>

<?php
include('footer.php');
?>
