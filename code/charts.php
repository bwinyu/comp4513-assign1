<?php 
$headertext = "Charts";
include "includes/head.inc.php";
include "includes/charts.inc.php";
?>
<!-- Load JS for Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="js/charts.js"></script>

    <div class="page-content mdl-grid">
            <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
                <div class="mdl-card__title mdl-color--teal-500">
                    <h2 class="mdl-card__title-text">Visits Per Month</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <div  id = "chartSubmitSpacing">
                        Select a month to view visits:
                            <?php
                                echo createMonthDropdown("areaChartMonth");
                            ?>
                    </div>
                    <div id = "areaChart">
                    </div>
                    <div class="mdl-grid loading" id="areaChartLoad">
                        <div class="mdl-spinner mdl-js-spinner is-active"></div>
                    </div>
                </div>
            </div>

        <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            <div class="mdl-card__title mdl-color--teal-500">
                <h2 class="mdl-card__title-text">Geo Chart</h2>
            </div>
            <div class="mdl-card__supporting-text">
                <div id = "chartSubmitSpacing">
                    Select a month to view Geographic Data for visits:
                    <?php
                        echo createMonthDropdown("geoChartMonth");
                    ?>
                </div>
                    <div id = "geoChart">
                </div>
                <div class="mdl-grid loading" id="geoChartLoad">
                    <div class="mdl-spinner mdl-js-spinner is-active"></div>
                </div>
            </div>
        </div>

        <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            <div class="mdl-card__title mdl-color--teal-500">
                <h2 class="mdl-card__title-text">Visit Data Column Chart</h2>
            </div>
            <div class="mdl-card__supporting-text">
                <div id = "chartSubmitSpacing">
                    <select id = "colChartCountrySelect1" class="countrySelect"></select>
                    <select id = "colChartCountrySelect2" class="countrySelect"></select>
                    <select id = "colChartCountrySelect3" class="countrySelect"></select>
                    <input class="mdl-button mdl-button--raised mdl-button--accent" id="colChartBtn" type="submit" value="Chart It">
                <input class="mdl-button mdl-button--raised mdl-button--accent" id="switchBarChartAxisBtn" type="submit" value="Switch">
                </div>
                <div id = "colChart">
                </div>
                <div class="mdl-grid loading" id="colChartLoad">
                    <div class="mdl-spinner mdl-js-spinner is-active"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="snackbar-error" class="mdl-js-snackbar mdl-snackbar">
        <div class="mdl-snackbar__text"></div>
        <button class="mdl-snackbar__action" type="button"></button>
    </div>

<?php include "includes/footer.inc.php" ?>
