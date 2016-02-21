<?php 
$headertext = "Charts";
include "includes/head.inc.php";
include "lib/helpers/charts-config.php";
?>


<!-- content here -->

<form action="charts.php" method="get">

    <div class="page-content mdl-grid">
        <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            <div class="mdl-card__title mdl-color--teal-500">
                <h2 class="mdl-card__title-text">Visits Per Month</h2>
            </div>
            <div class="mdl-card__supporting-text">


                Select a month to chart visits:
                <select name="month">
                    <option value="Jan">January</option>
                    <option value="Feb">February</option>
                    <option value="Mar">March</option>
                    <option value="Apr">April</option>
                </select>

            </div>

        </div>

        <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            <div class="mdl-card__title mdl-color--teal-500">
                <h2 class="mdl-card__title-text">Geo Chart</h2>
            </div>
            <div class="mdl-card__supporting-text">

            </div>
        </div>

        <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            <div class="mdl-card__title mdl-color--teal-500">
                <h2 class="mdl-card__title-text">Visit Data Column Chart</h2>
            </div>
            <div class="mdl-card__supporting-text">

            </div>
        </div>
    </div>
</form>

<?php include "includes/footer.inc.php" ?>
