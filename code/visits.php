<?php
$headertext = "Visits - Test";
include "includes/head.inc.php";
?>

<script type="text/javascript" src="js/visits.js"></script>

   <div class="mdl-cell mdl-cell--12-col">

      <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
         <div class="mdl-card__title mdl-color--teal-500">
            <h2 class="mdl-card__title-text">Visits</h2>
         </div>
         <div class="mdl-card__actions mdl-card--border" id="visits">

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
