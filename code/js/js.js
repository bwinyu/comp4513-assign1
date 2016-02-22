$(document).ready (function () {

	/*
	 * Retrieves all visit information to be used for browser visits table
	 */
	var browserResults = [];
	var browserList = jsonRequest ("api.php?data=Browsers");
	for (var i = 0; i < browserList.length; i++) {
		browserResults[browserList[i].name] = jsonRequest ("api.php?data=Visits&action=countbybrowser&param=" + browserList[i].id);
	}
	var browserHeaders = ["Browser", "Visits"];
	$("#browserVisits").html (createTable (browserHeaders, browserResults));

	/*
	 * Retrieves all brand information to be used for brand visits dropdown
	 */
	var brandResults = [];
	var brandList = jsonRequest ("api.php?data=Devicebrand");
	for (var i = 0; i < brandList.length; i++) {
		brandResults[brandList[i].id] = brandList[i].name;
	}
	$("#brandDropdown").html (createDropdown (brandResults, "id", "name", "brandId", "Brand", "brandVisits"));

	/*
	 * Retrieves all country information to be used for country visits dropdown
	 */
	/*
	var countryResults = [];
	var countryList = jsonRequest ("api.php?data=Devicebrand");
	for (var i = 0; i < countryList.length; i++) {
		countryResults[brandList[i].id] = brandList[i].name;
	}
	$("#brandDropdown").html (createDropdown (countryResults, "id", "name", "brandId", "Brand", "brandVisits"));
	*/

	/*
	 * Creates brand visits table when select is changed
	 */
	$("#brandDropdown").on ("change", function () {
		console.log (this.value);
		var brandVisits = jsonRequest ("api.php?data=Visits&action=countbydevicebrand&param=" + this.value);
		var brandHeaders = ["Brand", "Visits"];
		$("#brandVisits").html (createTable (brandHeaders, brandVisits));	
	});

});


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

function createTable (headers, tableData) {
   var tableHtml = "<table class=\"mdl-data-table mdl-cell mdl-cell--12-col mdl-shadow--2dp\">";
   tableHtml += "<thead>";
   tableHtml += "<tr>";
   for (var header in headers) {
      tableHtml += "<th class=\"mdl-data-table__cell--non-numeric\">" + headers[header] + "</th>";
   }
   tableHtml += "</tr>";
   tableHtml += "<tbody>";
   for (var key in tableData) {
      tableHtml += "<tr>";
      tableHtml += "<td class=\"mdl-data-table__cell--non-numeric\">" + key + "</td>";
      tableHtml += "<td class=\"mdl-data-table__cell--non-numeric\">" + tableData[key] + "</td>";
      tableHtml += "</tr>";
   }
   tableHtml += "</tbody>";
   tableHtml += "</table>";
   return tableHtml;
}

function createDropdown (dropdownarray, arrayId, arrayName, selectGet, selectName, tableId) {
   var listHtml = "<select id=" + tableId + " name=\"" + selectGet + "\">";
   listHtml += "<option value=\"\">Select " + selectName + "</option>";
   for (var key in dropdownarray) {
      optionValue = key;
      optionText = dropdownarray[key];
      listHtml += "<option value=\"" + optionValue + "\">" + optionText + "</option>";
   }
   listHtml += "</select>";
   return listHtml;
}