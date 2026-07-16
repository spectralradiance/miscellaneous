

<?php ob_start(); ?>
<h2>The Truth about Fur</h2>
<p>Each year, hundreds of millions of animals are killed in the global fur trade.</p>
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
        background: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.1)), url('/content/headers/mink1.jpg');
        background-position:50% 60%;
        background-size: cover;
    }
</style>

<div id="app" class="container">
    <select class="browser-default" v-model="selected_year">
        <option v-for="year in years" :value="year">{{year}}</option>
    </select>
    <table v-if="usa_mink_data_sorted.length > 0">
        <thead>
            <th>{{usa_mink_data_sorted[0].state}}</th>
            <th>{{usa_mink_data_sorted[0].value.toLocaleString()}}</th>
        </thead>
        <tbody>
            <tr v-for="(row, index) in usa_mink_data_sorted.slice(1)">
                <td>{{row.state}}</td>
                <td>{{row.value.toLocaleString()}}</td>
            </tr>
        </tbody>
    </table>
</div>
<script>
    // let mink_data = require('./usa_mink_data.json')
    // console.log(mink_data)
    
    let app = new Vue({
        el: '#app',
        data: {
            usa_mink_data: [],
            selected_year: 0,
            years: []
        },
        methods: {},
        computed: {
            usa_mink_data_sorted: function() {
                let r = this.usa_mink_data.filter(d => d.year == this.selected_year)
                r.sort((a, b) => b.value - a.value)
                return r
            }
        },
        created: function() {
            fetch("/content/usa_mink_data.json")
                .then(response => response.json())
                .then(json => {
                    this.usa_mink_data = json
                    // for (let i=0; i<this.usa_mink_data.length; ++i) {
                    //     if (this.usda_)
                    // }
                    this.years = this.usa_mink_data.map(d => d.year)
                    this.years = this.years.filter((d, i) => this.years.indexOf(d) == i)
                    this.years.sort((a, b) => b - a)
                    this.selected_year = this.years[0]
                });
        }
    })

</script>

<?php
include('footer.php');
?>