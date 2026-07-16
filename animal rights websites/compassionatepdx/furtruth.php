

<?php ob_start(); ?>
<h2>The Truth about Fur</h2>
<div class="subtitle">Each year, hundreds of millions of animals are killed in the global fur trade, including rabbits, mink, foxes, coyotes, chinchillas, rabbits, seals, dogs, and cats. Roughly 85% of animals killed for fur are raised on fur factory farms, with the remainder trapped in the wild.</div>
<!-- <p>You can be their voice.</p>
<a href="" class="btn orange">Take Action</a> -->
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
        background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('/content/headers/mink1.jpg');
        background-position:50% 60%;
        background-size: cover;
    }
    nav a, nav h1, nav h2, .subtitle {
        text-shadow: -1px -1px 20px #111, 1px -1px 20px #111, -1px 1px 20px #111, 1px 1px 20px #111;
    }
    .card-panel {
        background-color: var(--card-background);
        box-shadow: var(--card-shadow) !important;
        border: var(--card-border);
        color: var(--card-foreground);
    }
    .card {
        
    }
    .fact img {
        max-width:100%;
    }
    .fact .card-panel {
        height:300px;
    }
    .fact .image-container .card-panel {
        background-size: cover;
        background-position: center;
        
        /* border:2px solid #000; */
        outline: 1px solid #fff;
        outline-offset: -4px;
    }
    .fact .image-container {
        height:300px;
        position:relative;
        
    }
    .fact_title {
        font-size:2rem;
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


<div id="app" class="container">
    <div class="row fact" v-for="fact in facts">
        <div class="col s12 m6">
            <div class="card-panel">
                <div class="fact_title">{{fact.title}}</div>
                <span v-html="fact.text"></span>
            </div>
        </div>
        <div class="col s12 m6 image-container">
            <div class="card-panel" :style="{ backgroundImage: 'url(\'/content/facts/' + fact.image.file_name + '\')' }"></div>
            <a class="image_fact_source" :href="fact.image.source.url">{{ fact.image.source.name }}</a>
        </div>
    </div>
</div>

<script>








    let app = new Vue({
        el: '#app',
        data: {
            facts: [{
                title: 'Cage Psychosis',
                text: 'Animals killed on fur farms spend their entire lives in cramped cages. These species are wild, with territorial ranges in the hundreds of acres. Unable to engage in any natural behaviors like running, playing, and digging, the confinement and boredom often leads to cage psychosis - frantic pacing, self-mutilation, and cannibalism.',
                image: {
                    file_name: 'GostaLarssonEksjoMinkFur_Sweden_JMcArthur_2010-6927.jpg',
                    source: {
                    }
                }
            },{
                title: 'Slaughter',
                text: 'Common methods of killing animals on fur farms are anal electrocution, gassing, suffocation, and neck-breaking, while trapped animals are often either shot or bludgeoned to death. In the wild mink will live 3-4 years on average (up to 10), on fur farms they\'re slaughtered at 8 months old. Most of the world\'s fur comes from China where there is no regulation.',
                image: {
                    file_name: 'FurCanada_MNR_SPCASeizure_QC_JMcArthur_20140804-3343EDIT.jpg',
                    source: {
                    }
                }
            // },{
            //     title: 'Killed for Fashion',
            //     text: 'It takes 50-60 minks, 15-40 foxes, or 150-300 chinchillas to make a single fur coat.',
            //     sources: [
            //         'https://www.animal-ethics.org/animal-exploitation-section/animals-used-for-clothing-introduction/fur-farms/',
            //     ],
            //     image: {
            //         file_name: 'markus-spiske-HMOi1xhIkeI-unsplash.jpg',
            //         source: {
            //             name: 'Markus Spiske',
            //             url: 'https://unsplash.com/photos/HMOi1xhIkeI'
            //         }
            //     }
            },{
                title: 'Trapping',
                text: 'Animals trapped in the wild are often stuck in traps for days, exposed to the elements, injured and bleeding, and without food or water. Traps are indiscriminate, sometimes killing companion animals and endangered species.',
                sources: [],
                image: {
                    file_name: 'coyote_born_free_usa.jpg',
                    source: {
                    }
                }
            },{
                title: 'Pollution',
                text: 'The fur industry contributes to water pollution through the discharge of nitrogen and phosphorous in feces. According to a Michigan State University study, the US mink industry alone adds almost 1,000 tons each year.',
                sources: [],
                image: {
                    file_name: 'LindasenMinkFur_Sweden_JMcArthur_2010-5132.jpg',
                    source: {

                    }
                }
            // },{
            //     title: 'Sustainability & Faux Fur',
            //     text: 'There are Nobody looks good wearing someone else\'s skin.',
            //     sources: [],
            //     image: {
            //         file_name: 'LindasenMinkFur_Sweden_JMcArthur_2010-5132.jpg',
            //         source: {

            //         }
            //     }
            // },{
            //     title: 'Ethics',
            //     text: 'Animals are not ours to use for fashion. Fur is a product of extreme violence.',
            //     sources: [],
            //     image: {
            //         file_name: 'LindasenMinkFur_Sweden_JMcArthur_2010-5132.jpg',
            //         source: {

            //         }
            //     }
            }]
        }
    })



</script>





<?php
include('footer.php');
?>