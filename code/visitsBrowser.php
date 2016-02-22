<?php
require_once ("lib/helpers/visits-setup.inc.php");

$headertext = "Visits Browser";
include "includes/head.inc.php";
include "includes/visitsBrowser.inc.php";
?>

<div class="page-content mdl-grid">

    <div class="mdl-cell mdl-cell--12-col">

        <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            <div class="mdl-card__title mdl-color--teal-500">
                <h2 class="mdl-card__title-text">Filter</h2>
            </div>
            <div class="mdl-card__supporting-text">
                <form>
                    <input type="text" name="Country"/>
                    <div class="mdl-card__actions mdl-card--border">
                        <?php
                        /*
                         * Generate dropdown list for Device Type
                         */
                        echo createDropdown ($typesList, "id", "name", "type", "Device Type");
                        echo createDropdown ($brandList, "id", "name", "type", "Brand Type");
                        echo createDropdown ($browserList, "id", "name", "type", "Browser Name");
                        echo createDropdown ($referrerList, "id", "name", "type", "Referrer Name");
                        echo createDropdown ($osList, "id", "name", "type", "OS Name");
                        ?>

                    </div>
                    <input class="mdl-button mdl-button--raised mdl-button--accent" type="submit" value="Submit">
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
