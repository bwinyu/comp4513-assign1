<?php 
/*
 * Feb 23, 2016
 *
 * Baldwin Yu, Joseph Balatbat, Matt Grixti, Philip Young
 * COMP-4513 Assignment 1 - Admin Dashboard Hme Page - PHP Version
 *
 * This page displays three material cards - browser visits, brand visits, country visits
 */

require_once ("lib/helpers/visits-setup.inc.php");

$headertext = "Home - PHP Version";
include "includes/head.inc.php";

include "includes/index.inc.php";

?>

<div class="page-content mdl-grid">

   <div class="mdl-cell mdl-cell--6-col">

      <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
         <div class="mdl-card__title mdl-color--teal-500">
            <h2 class="mdl-card__title-text">Browser Visits</h2>
         </div>
         <div class="mdl-card__supporting-text">
            <?php
            /*
             * Generate table html for browser visits
             */
            echo createTable ($browserHeaders, $browserVisits);
            ?>
         </div>
      </div>

   <form action="index.php" method="get">

      <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
         <div class="mdl-card__title mdl-color--teal-500">
            <h2 class="mdl-card__title-text">Brand Visits</h2>
         </div>
         <div class="mdl-card__actions mdl-card--border">
            <?php
            /*
             * Generate dropdown list for brands
             */
            echo createDropdown ($brandList, "id", "name", "brandId", "Brand");
            ?>
            <input class="mdl-button mdl-button--raised mdl-button--accent" type="submit" value="Submit">
         </div>
         <?php
         /*
          * Generate table html for brand visits if the brand id is set in the query string
          */
         if (isset ($_GET["brandId"]) && $_GET["brandId"] != "") {
            echo "<div class=\"mdl-card__supporting-text\">";
            echo createTable ($brandHeaders, $brandResults);
            echo "</div>";
         }
         ?>
      </div>

   </div>

   <div class="mdl-cell mdl-cell--6-col">

      <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
         <div class="mdl-card__title mdl-color--teal-500">
            <h2 class="mdl-card__title-text">Country Visits</h2>
         </div>
         <div class="mdl-card__actions mdl-card--border">
            <?php
            /*
             * Generate dropdown list for continents
             */
            echo createDropdown ($continentList, "ContinentCode", "ContinentName", "continentCode", "Continent");
            ?>
            <input class="mdl-button mdl-button--raised mdl-button--accent" type="submit" value="Submit">
         </div>
         <?php
         /*
          * Generate table html for country visits if the continent code is set in the query string
          */
         if (isset ($_GET["continentCode"]) && $_GET["continentCode"] != "") {
            echo "<div class=\"mdl-card__supporting-text\">";
            echo createTable ($countryHeaders, $countryResults);
            echo "</div>";
         }
         ?>
      </div>

   </div>

   </form>
   
</div>

<?php include "includes/footer.inc.php" ?>
