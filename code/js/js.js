/*
 * Feb 23, 2016
 *
 * Baldwin Yu, Joseph Balatbat, Matt Grixti, Philip Young
 * COMP-4513 Assignment 1 - Admin Dashboard Hme Page - JS home page backend code
 *
 * This page is the back-end JavaScript/jQuery code for the JS home page
 */


$(document).ready (function () {
	/********** ON LOAD **********/
	/*
	 * Retrieves all visit information to be used for browser visits table
	 */
	var browserResults = [];
	var browserList = jsonRequest ("api.php?data=Browsers");
	var totalVisits = 0.0;
	for (var i = 0; i < browserList.length; i++) {
		browserResults[browserList[i].name] = jsonRequest ("api.php?data=Visits&action=countbybrowser&param=" + browserList[i].id);
		totalVisits += parseFloat (browserResults[browserList[i].name]);
	}
	for (var key in browserResults) {
		browserResults[key] = ((browserResults[key] / totalVisits) * 100).toFixed (2) + "%";
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
	$("#brandDropdown").html (createDropdown (brandResults, "id", "name", "brandId", "Brand", "brandSelect"));

	/*
	 * Retrieves all country information to be used for country visits dropdown
	 */
	var continentResults = [];
	var continentList = jsonRequest ("api.php?data=Continents");
	for (var i = 0; i < continentList.length; i++) {
		continentResults[continentList[i].ContinentCode] = continentList[i].ContinentName;
	}
	$("#continentDropdown").html (createDropdown (continentResults, "ContinentCode", "ContinentName", "continentCode", "Continent", "continentSelect"));

	/*
	 * Hide loading gifs
	 */
	$("#loadingBrand").hide ();
	$("#loadingCountry").hide ();

	/********** ON CHANGE **********/
	/*
	 * Creates brand visits table when select is changed for brand dropdown
	 */
	$("#brandSelect").on ("change", function () {
		$("#brandVisits").html ("");
		var brandVisits = jsonRequest ("api.php?data=Visits&action=countbydevicebrand&param=" + this.value, "#loadingBrand");
		var brandVisitResults = [];
		brandVisitResults [$("#brandSelect option:selected").text()] = brandVisits;
		var brandHeaders = ["Brand", "Visits"];
		$("#brandVisits").html (createTable (brandHeaders, brandVisitResults));
	});

	/*
	 * Creates country visits table when select is changed for continent dropdown
	 */
	$("#continentSelect").on ("change", function () {
		var countryList = jsonRequest ("api.php?data=Countries&action=filterbycontinentcode&param=" + this.value);
		var countryResults = [];
		for (var i = 0; i < countryList.length; i++) {
			countryResults[countryList[i].CountryName] = jsonRequest ("api.php?data=Visits&action=countbycountrycode&param=" + countryList[i].ISO, "#loadingCountry");
		}
		var countryHeaders = ["Country", "Visits"];
		$("#countryVisits").html (createTable (countryHeaders, countryResults));
	});

});

/*
 * Function that returns the data in a JSON request
 */
function jsonRequest (url) {
	return (function () {
		var result = null;
		$.ajax({
			'async': true,
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

/*
 * Function that returns the data in a JSON request and displays loading gif
 */
function jsonRequest (url, loadingId) {
	return (function () {
		var result = null;
		$(loadingId).show ();
		$.ajax({
			'async': false,
	        'global': false,
	        'url': url,
	        'dataType': "json",
	        'success': function (data) {
	            result = data;
	            $(loadingId).hide ();
	        }
		});
		return result;
	})();
}

/*
 * Function that generates a table based on headers and table data
 */
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

/*
 * Function that generates a dropdown list based on the dropdown array,
 * array id, array name, select get id, select name, and select id
 */
function createDropdown (dropdownarray, arrayId, arrayName, selectGet, selectName, selectId) {
   var listHtml = "<select id=" + selectId + " name=\"" + selectGet + "\">";
   listHtml += "<option value=\"\">Select " + selectName + "</option>";
   for (var key in dropdownarray) {
      optionValue = key;
      optionText = dropdownarray[key];
      listHtml += "<option value=\"" + optionValue + "\">" + optionText + "</option>";
   }
   listHtml += "</select>";
   return listHtml;
}