<?php
require_once ("lib/helpers/visits-setup.inc.php");

$headertext = "Visits Browser";
include "includes/head.inc.php";
include "includes/visitsBrowser.inc.php";
?>
<script src="js/visitsBrowser.js"></script>
<script src="js/jquery.easy-autocomplete.min.js"></script>
<div class="page-content mdl-grid">

    <div class="mdl-cell mdl-cell--12-col">

        <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            <div class="mdl-card__title mdl-color--teal-500">
                <h2 class="mdl-card__title-text">Filter</h2>
            </div>
            <div class="mdl-card__supporting-text">
                <form id="filters">
                    <div class="easy-autocomplete">
                        <input id="country" placeholder="Country Search" autocomplete="off" name="Country"/>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <?php
                        /*
                         * Generate dropdown lists
                         */
                        echo createDropdown ($typesList, "id", "name", "type", "Device Type");
                        echo createDropdown ($brandList, "id", "name", "brand", "Brand Type");
                        echo createDropdown ($browserList, "id", "name", "browser", "Browser Name");
                        echo createDropdown ($referrerList, "id", "name", "referrer", "Referrer Name");
                        echo createDropdown ($osList, "id", "name", "os", "OS Name");
                        ?>

                    </div>
                    <button id="filterbtn" class="mdl-button mdl-button--raised mdl-button--accent">
                </form>

            </div>
        </div>
    </div>
    <div class="mdl-cell mdl-cell--12-col">
        <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            <div class="mdl-card__title mdl-color--teal-500">
                <h2 class="mdl-card__title-text">Visits</h2>
            </div>
            <div class="mdl-card__supporting-text">


            </div>
        </div>
    </div>
   
</div>

<?php include "includes/footer.inc.php" ?>
