$(document).ready (function () {
   /*
    * Fetch all visit information based on filters
    */
   var visitResults = jsonRequest ("api.php?data=Visits&action=filtervisitsdata&param=Country,Browser&param2=Canada,Chrome");
   for (var result in visitResults) {
      visitResults[visitResults[result].id] = visitResults[result];
   }
   var visitHeaders = ["Visit Date", "Visit Time", "IP Address", "Country", ""];
   $("#visitsTest").html (createTable (visitHeaders, visitResults));

   /*
    * When a button is clicked for a result, show the modal with info using the visit id
    */
   $(".rowButton").on ("click", function () {
      $("#visitModal").css ("display", "block");
      $("#visitContent").html (createDialog (visitResults[this.id]));
      $("#visitClose").on ("click", function () {
         $("#visitModal").css ("display", "none");
      });
   });
});

/*
 * Function that generates dialog information
 */
function createDialog (visitData) {
   var visitHtml = "<span class=\"close\" id=\"visitClose\">x</span>";
   visitHtml += "<p><b>Visit Date: </b>" + visitData.Date + "</p>";
   visitHtml += "<p><b>Visit Time: </b>" + visitData.Time + "</p>";
   visitHtml += "<p><b>IP Address: </b>" + visitData.ip_address + "</p>";
   visitHtml += "<p><b>Country: </b>" + visitData.Country + "</p>";
   visitHtml += "<p><b>Device Type: </b>" + visitData.DeviceType + "</p>";
   visitHtml += "<p><b>Brand: </b>" + visitData.DeviceBrand + "</p>";
   visitHtml += "<p><b>Browser: </b>" + visitData.Browser + "</p>";
   visitHtml += "<p><b>Referrer: </b>" + visitData.Referrer + "</p>";
   visitHtml += "<p><b>Operating System: </b>" + visitData.OS + "</p>";
   return visitHtml;
}

/*
 * Function that generates a table with visits information
 */
function createTable (headers, tableData) {
   var tableHtml = "<table id=\"visitsTable\" class=\"mdl-data-table mdl-cell mdl-cell--12-col mdl-shadow--2dp\">";
   tableHtml += "<thead>";
   tableHtml += "<tr>";
   for (var header in headers) {
      tableHtml += "<th class=\"mdl-data-table__cell--non-numeric\">" + headers[header] + "</th>";
   }
   tableHtml += "</tr>";
   tableHtml += "<tbody>";
   for (var row in tableData) {
      tableHtml += "<tr>";
      tableHtml += "<td class=\"mdl-data-table__cell--non-numeric\">" + tableData[row].Date + "</td>";
      tableHtml += "<td class=\"mdl-data-table__cell--non-numeric\">" + tableData[row].Time + "</td>";
      tableHtml += "<td class=\"mdl-data-table__cell--non-numeric\">" + tableData[row].ip_address + "</td>";
      tableHtml += "<td class=\"mdl-data-table__cell--non-numeric\">" + tableData[row].Country + "</td>";
      tableHtml += "<td><button id=\"" + tableData[row].id + "\" class=\"rowButton mdl-button mdl-js-button mdl-button--raised\">More</button></td>";
      tableHtml += "</tr>";
   }
   tableHtml += "</tbody>";
   tableHtml += "</table>";
   return tableHtml;
}

/*
 * Function that returns the data in a JSON request
 */
function jsonRequest (url) {
   return (function () {
      var result = null;
      $.ajax({
         'async': false,
           'global': false,
           'url': url,
           'dataType': "json",
           'success': function (data) {
               result = data;
           }
      });
      return result;
   })();
}