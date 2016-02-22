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
            <div class="mdl-card__supporting-text" id="filters">
                    <div class="mdl-card__actions mdl-card--border">
                        <div class="easy-autocomplete">
                            <input id="country" placeholder="Country Search" autocomplete="off" name="Country"/>
                        </div>
                        <?php
                        /*
                         * Generate dropdown lists
                         */
                        echo createDropdown ($typesList, "id", "name", "DeviceType", "Device Type");
                        echo createDropdown ($brandList, "id", "name", "DeviceBrand", "Brand Type");
                        echo createDropdown ($browserList, "id", "name", "Browser", "Browser Name");
                        echo createDropdown ($referrerList, "id", "name", "Referrer", "Referrer Name");
                        echo createDropdown ($osList, "id", "name", "OS", "OS Name");
                        ?>

                    </div>

            </div>
        </div>
    </div>
    <div class="mdl-cell mdl-cell--12-col">
        <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            <div class="mdl-card__title mdl-color--teal-500">
                <h2 class="mdl-card__title-text">Visits</h2>
            </div>
            <div class="mdl-card__actions mdl-card--border" id="visits">

            </div>
        </div>
    </div>

    <div class="mdl-cell--12-col">

        <div id="visitModal" class="modal">

            <div class="modal-content" id="visitContent">

            </div>

        </div>
    </div>

</div>
   
</div>

<?php include "includes/footer.inc.php" ?>
