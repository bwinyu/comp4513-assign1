<?php
/*
 * Feb 23, 2016
 *
 * Baldwin Yu, Joseph Balatbat, Matt Grixti, Philip Young
 * COMP-4513 Assignment 1 - Admin Dashboard Hme Page - JS home page
 *
 * This page is the front-end code for the JS home page
 */

$headertext = "Home - JS Version";
include "includes/head.inc.php";
?>

<script type="text/javascript" src="js/js.js"></script>

<div class="page-content mdl-grid">

   <div class="mdl-cell mdl-cell--6-col">

      <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
         <div class="mdl-card__title mdl-color--teal-500">
            <h2 class="mdl-card__title-text">Browser Visits</h2>
         </div>
         <div class="mdl-card__supporting-text" id="browserVisits">
         </div>
         <div id="loadingBrand"><img src="images/loading.gif"></div>
      </div>

      <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
         <div class="mdl-card__title mdl-color--teal-500">
            <h2 class="mdl-card__title-text">Brand Visits</h2>
         </div>
         <div class="mdl-card__actions mdl-card--border" id="brandDropdown">
            <div class="mdl-card__actions mdl-card--border" id="brandDropdown">
               <select id="brandSelect" name="Brand"></select>
            </div>
         </div>
         <div class="mdl-card__supporting-text" id="brandVisits">
         </div>

<!--            <center><div id="loadingBrand"><img src="images/loading.gif"></div></center>-->
      </div>

   </div>

   <div class="mdl-cell mdl-cell--6-col">

      <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
         <div class="mdl-card__title mdl-color--teal-500">
            <h2 class="mdl-card__title-text">Country Visits</h2>
         </div>
         <div class="mdl-card__actions mdl-card--border" id="continentDropdown">
            <select id="continentSelect" name="Continent"></select>
         </div>
         <div class="mdl-card__supporting-text" id="countryVisits">
<!--            <center><div id="loadingCountry"><img src="images/loading.gif"></div></center>-->
         </div>
      </div>

   </div>
   
</div>

<?php include "includes/footer.inc.php" ?>
