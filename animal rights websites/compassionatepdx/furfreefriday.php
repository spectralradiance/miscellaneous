

<?php ob_start(); ?>
<h2>Fur Free Friday 2020</h2>
<div class="subtitle">Join us for the annual Fur Free Friday Rally the day after Thanksgiving in Downtown Portland! Everyone is welcome to this important event focused on encouraging retailers in adopting fur free policies and to urging lawmakers to pass a fur sale ban in Oregon. All in-person events will be livestreamed!</div>
<a class="btn" href="/furtruth">Learn About Fur</a>
<a class="btn" href="#take_action">Take Action</a>

<a class=""></a>
<?php
$title = ob_get_clean();
$header_image_credit_text = '';
$header_image_credit_url = '';
?>


<?php
include('header.php');
?>

<style type="text/css">
    nav {
        background: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.1)), url('/content/headers/fox-1883658_1920 _flipped.jpg');
        background-position:50% 50%;
        background-size: cover;
    }

    .card {
        background-color: var(--card-background);
        color: var(--card-foreground);
        display:flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .card {
        box-shadow: var(--card-shadow) !important;
        border: var(--card-border);
    }
    .card-action {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
    .card-action a {
        margin: 10px;
    }
    .fact img {
        max-width:100%;
    }
    .fact .card-panel, .card {
        min-height:300px;
    }
    .fact .image-container .card-panel {
        background-size: cover;
        background-position: center;
        
        /* border:2px solid #000; */
        outline: 1px solid #fff;
        outline-offset: -4px;
    }
    .fact .image-container {
        min-height:300px;
        position:relative;
        
    }
    .fact_title {
        font-size:2rem;
        color: white;
        margin-bottom:10px;
    }
    .image_fact_source {
        position:absolute;
        bottom:0;
        right:20px;
        color:white;
        font-size: 0.7rem;
        opacity:0.5;
    }
    
    
</style>



<div id="take_action" class="container">
    <div class="row fact" v-for="fact in facts">
        <div class="col s12 m6">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">{{fact.title}}</span>
                    <p v-html="fact.text"></p>
                </div>
                <div class="card-action" v-if="fact.links.length > 0">
                    <a class="btn" v-for="link in fact.links" :href="link.url">{{link.text}}</a>
                </div>
            </div>

            <!-- <div class="card-panel">
                <div class="fact_title">{{fact.title}}</div>
                <span class="white-text" ></span>
            </div> -->
        </div>
        <div class="col s12 m6 image-container">
            <div class="card-panel" :style="{ backgroundImage: 'url(\'/content/furfreefriday/' + fact.image.file_name + '\')' }"></div>
            <a class="image_fact_source" :href="fact.image.source.url">{{ fact.image.source.name }}</a>
        </div>
    </div>
</div>

<script>








    let app = new Vue({
        el: '#take_action',
        data: {
            facts: [],
                image: {
                    file_name: '83823431_10162762324235401_3203357239817535488_o.jpg',
                    source: {
                        name: '',
                        url: ''
                    },
                },
                links: []
            }]
        }
    })



</script>






<?php
include('footer.php');
?>