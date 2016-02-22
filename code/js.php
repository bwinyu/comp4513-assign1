<?php
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
      </div>

      <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
         <div class="mdl-card__title mdl-color--teal-500">
            <h2 class="mdl-card__title-text">Brand Visits</h2>
         </div>
         <div class="mdl-card__actions mdl-card--border" id="brandDropdown">
            
         </div>
         <div class="mdl-card__supporting-text" id="brandVisits">
            
         </div>
      </div>

   </div>

   <div class="mdl-cell mdl-cell--6-col">

      <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
         <div class="mdl-card__title mdl-color--teal-500">
            <h2 class="mdl-card__title-text">Country Visits</h2>
         </div>
         <div class="mdl-card__actions mdl-card--border" id="countryDropdown">

         </div>
         <div class="mdl-card__supporting-text" id="countryVisits">
         
         </div>
      </div>

   </div>
   
</div>

<?php include "includes/footer.inc.php" ?>
