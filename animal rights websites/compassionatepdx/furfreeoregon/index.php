



<?php ob_start(); ?>
<h2>Fur Free Oregon</h2>
<div class="subtitle">Let's make Oregon the next Fur Free state!</div>
<!-- <a class="btn" href="#take_action">Take Action</a> -->
<?php
$title = ob_get_clean();
$header_image_credit_text = '';
$header_image_credit_url = '';
?>

<?php
include('../header.php');
?>

<style>
    nav {
        /* background: linear-gradient(rgba(0,0,0,.3), rgba(0,0,0,.3)), url('/content/headers/raccoondog1.jpg');
        background-position:20% 50%;
        background-size: 140%; */

        background: linear-gradient(rgba(0,0,0,.3), rgba(0,0,0,.3)), url('/content/headers/fox2.jpg');
        background-position:center;
        background-size: cover;
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

</style>


<!-- <div id="take_action" class="container">
    <div class="row">
        <div class="col m6">
            <div class="card-panel left-card">
                <h5>Contact Your State Rep</h5>
                <p>Email and/or call your state representative and let them know you support a ban on the sale of fur products in Oregon. You can use <a href="http://action.humanesociety.org/site/PageServer?pagename=electedOfficials">this tool</a> provided by HSUS to find your state representatives.</p>
                <a class="btn" href="http://action.humanesociety.org/site/PageServer?pagename=electedOfficials">Find Your Rep</a>
            </div>
        </div>
        <div class="col m6 right-card">
            <div class="template_letter_header">
                <h5>Template Letter</h5>
                <a id="btn_copy" class="btn" href="#!">copy</a>
            </div>
            <textarea rows="7" id="textarea_email_template">Dear **Representative's Name**

My name is **Your Name**, a constituent of your district, and I'm asking you to support the state-wide ban on the sale of new fur products.</textarea>
        </div>
    </div>
</div>



<script>
    let btn_copy = document.querySelector('#btn_copy')
    let textarea_email_template = document.querySelector('#textarea_email_template')
    btn_copy.addEventListener('click', function() {
        navigator.clipboard.writeText(textarea_email_template.value)
        M.toast({html: 'Template Copied', displayLength: 1000})
    })
</script> -->

<div class="img_header"><img src="/content/furfreeoregon/83823431_10162762324235401_3203357239817535488_o.jpg"/></div>

<?php
include('../footer.php');
?>