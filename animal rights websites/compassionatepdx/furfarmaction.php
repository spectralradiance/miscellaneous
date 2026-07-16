



<?php ob_start(); ?>
<h2>Call on Governor Brown<br/>to End Fur Farming in Oregon</h2>
<div class="subtitle">COVID-19 has spread to mink on fur farms throughout Europe, endangering the public and resulting in millions of mink being culled. Now the virus has begun spreading through mink farms in the United States. Call on Governor Brown to take executive action and buy-out Oregon's remaining fur farms.</div>
<a class="btn" href="tel:">Call</a>
<a class="btn" href="">send a message</a>
<a class="btn" href="#take_action">More Info</a>
<?php
$title = ob_get_clean();
$header_image_credit_text = '';
$header_image_credit_url = '';
?>

<?php
include('header.php');
?>

<style>
    nav {
        /* background: linear-gradient(rgba(0,0,0,.3), rgba(0,0,0,.3)), url('/content/headers/MinkFurFarm_Sweden_JMcArthur_2009-1150.jpg');
        background-position:50% 20%;
        background-size: cover; */

        /* background: linear-gradient(rgba(0,0,0,.3), rgba(0,0,0,.3)), url('/content/headers/fox2.jpg');
        background-position:center;
        background-size: cover; */

        background: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.1)), url('/content/headers/fox-1883658_1920 _flipped.jpg');
        background-position:50% 50%;
        background-size: cover;

        /* background: linear-gradient(rgba(0,0,0,.3), rgba(0,0,0,.3)), url('/content/headers/fox2.jpg');
        background-position:center;
        background-size: cover; */
    }
    .img_header {
        margin:40px;
        text-align:center;
    }
    .img_header img {
        max-width:800px;
        box-shadow: 0 8px 17px 2px rgba(0,0,0,0.14), 0 3px 14px 2px rgba(0,0,0,0.12), 0 5px 5px -3px rgba(0,0,0,0.2)
    }
    .template_letter_header {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: stretch;
    }
    .template_letter_header a {
        margin: auto 0;
    }
    .left-card {
        color:white;
        background-color: #455a64;
        padding-bottom:40px;

    }
    .right-card {
        padding:20px !important;
    }
    #take_action textarea {
        height: auto;
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
    .card-panel li {
        margin-bottom:10px;
    }

</style>


<div id="take_action" class="container">
    <div class="row">
        <div class="col m6">
            <div class="card-panel left-card">
                
                <h5>Talking Points</h5>
                <ul class="browser-default">
                    <li>In April, COVID-19 was transmitted from farm workers to mink at two fur farms in the Netherlands. By June,
                        it had spread to 12 farms, mutated, and was transmitted back to humans. The government began culling tens of
                        thousands of mink to prevent these farms from becoming reservoirs for the virus (<a
                            href='https://www.sciencemag.org/news/2020/06/coronavirus-rips-through-dutch-mink-farms-triggering-culls-prevent-human-infections'>source</a>).
                    <li>Over 200 people have contracted mink-related variations of the virus, including a variation that's resistant to antibodies, raising fears it could render any vaccine we develop ineffective (<a
                            href='https://www.independent.co.uk/news/world/europe/denmark-coronavirus-minsk-covid-b1637064.html'>source</a>).</li>
                    <li>Spain culled 100,00 mink in July (<a href='https://www.bbc.com/news/world-europe-53439263'>source</a>), and
                        Denmark plans to cull 17 million mink and close all mink farms in the country (<a
                            href='https://www.bbc.com/news/world-europe-54818615'>source</a>). The virus also also been detected in
                        Sweden, Italy, and the United States, making 6 countries so far (<a
                            href='https://www.who.int/csr/don/06-november-2020-mink-associated-sars-cov2-denmark/en/'>source</a>)
                    </li>
                    <li>COVID-19 has spread rapidly through fur farms in in the US. It was first detected in Utah (<a
                            href='https://www.nytimes.com/2020/08/17/us/coronavirus-strikes-mink-in-utah.html'>source</a>) then
                        Michigan (<a
                            href='https://www.mlive.com/news/2020/10/michigan-mink-farm-tests-positive-for-virus-that-causes-covid-19-in-humans.html'>source</a>)
                        and Wisconsin (<a
                            href='https://www.wortfm.org/thousands-of-mink-dead-after-covid-19-outbreak-at-wisconsin-mink-farm/'>source</a>),
                        resulting in 10,000 mink deaths by October (<a
                            href='https://www.cnn.com/2020/10/09/us/mink-covid-outbreak-trnd/index.html'>source</a>). In November,
                        another outbreak in Wisconsin resulted in 5,400 mink dying (<a
                            href='https://www.jsonline.com/story/news/local/wisconsin/2020/11/06/two-taylor-county-mink-farms-under-quarantine-after-over-5-000-animals-died-from-covid-19/6174241002/'>source</a>).
                    </li>
                    <li>On November 6th, Governor Brown announced a 2-week pause on social activities to slow the spread of the
                        virus as new infections hit an all-time high in the state (<a
                            href='https://www.oregonlive.com/coronavirus/2020/11/gov-kate-brown-to-announce-two-week-pause-on-social-activities-for-select-counties-to-slow-coronavirus-spread.html'>source</a>).
                        She could use her authority to demand that all mink farms in the state immediately stop all breeding
                        operations, and work with the U.S. Department of Agriculture to coordinate a government buy-out program for
                        the state’s mink farms. (<a
                            href='https://animalwellnessaction.org/2020/10/22/animal-wellness-call-for-us-government-buyout-of-oregon-mink-farms-to-prevent-covid-super-spreaders/'>source</a>)
                    </li>
                </ul>
            </div>
        </div>
        <div class="col m6 right-card">
            <div class="template_letter_header">
                <h5>Template Letter</h5>
                <a id="btn_copy" class="btn" href="#!">copy</a>
            </div>
            <textarea rows="20" id="textarea_email_template">Dear Governer Brown

With COVID-19 cases once again skyrocketing in Oregon, I want to alert you to an alarming new risk from the fur trade. In April the virus was first detected on a mink farm in the Netherlands, and has since spread to farms throughout Europe, resulting in millions of mink being culled. The virus mutated and was transmitted back to humans, infecting over 200 people, and raising fears it would make any vaccine we developed ineffective. Please take executive action to stop all breeding operations on mink farms in Oregon, and work with the U.S. Department of Agriculture to coordinate a government buy-out program.</textarea>
        </div>
    </div>
</div>

<div class="img_header"><img src="/content/furfreeoregon/83823431_10162762324235401_3203357239817535488_o.jpg"/></div>

<script>
    let btn_copy = document.querySelector('#btn_copy')
    let textarea_email_template = document.querySelector('#textarea_email_template')
    btn_copy.addEventListener('click', function() {
        navigator.clipboard.writeText(textarea_email_template.value)
        M.toast({html: 'Template Copied', displayLength: 1000})
    })
</script>

<?php
include('footer.php');
?>