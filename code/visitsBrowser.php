<?php
/*
 * Feb 23, 2016
 *
 * Baldwin Yu, Joseph Balatbat, Matt Grixti, Philip Young
 * COMP-4513 Assignment 1 - Admin Dashboard Visits Browser Page
 *
 * This page is the front-end code for the visits browser page
 */

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
                    <input id="country" placeholder="Country Search" autocomplete="off" name="Country"/>
                    <table>
                        <tr>
                            <?php
                            /*
                             * Generate dropdown lists
                             */
                            echo '<td>' . createDropdown ($typesList, "id", "name", "DeviceType", "Device Type") . '</td>';
                            echo '<td>' . createDropdown ($brandList, "id", "name", "DeviceBrand", "Brand Type") . '</td>';
                            echo '<td>' . createDropdown ($browserList, "id", "name", "Browser", "Browser Name") . '</td>';
                            echo '<td>' . createDropdown ($referrerList, "id", "name", "Referrer", "Referrer Name") . '</td>';
                            echo '<td>' . createDropdown ($osList, "id", "name", "OS", "OS Name") . '</td>';
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="mdl-cell mdl-cell--12-col">
        <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            <div class="mdl-card__title mdl-color--teal-500">
                <h2 class="mdl-card__title-text">Visits</h2>
            </div>

            <div class="mdl-card__actions mdl-card--border">
                <div class="mdl-grid loading" id="loadingBar">
                    <div class="mdl-spinner mdl-js-spinner is-active"></div>
                </div>
                <div class="mdl-grid" id="visits"><!--Table generated will appear here--></div>
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
