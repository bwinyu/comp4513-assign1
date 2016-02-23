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
	 * Retrieves all brand information to be used for brand visits dropdown
	 */
	$("#loadingBrand").hide ();
	$("#loadingCountry").hide ();

	jsonRequest ("api.php?data=Devicebrand", '#loadingBrand', 'BrandDropdown', "#brandVisits");

	/*
	 * Retrieves all country information to be used for country visits dropdown
	 */
	jsonRequest ("api.php?data=Continents", '#loadingCountry', 'CountryDropdown', "#countryVisits");

	/*
	 * Retrieves all visit information to be used for browser visits table
	 */
	jsonRequest("api.php?data=Browsers", "#loadingBrowsers", "Browser", "#browserVisits");


	/********** ON CHANGE **********/
	/*
	 * Creates brand visits table when select is changed for brand dropdown
	 */
	$("#brandSelect").on ("change", function () {
		jsonRequest ("api.php?data=Visits&action=countbydevicebrand&param=" + this.value, "#loadingBrand", 'Brand', "#brandVisits");
	});

	/*
	 * Creates country visits table when select is changed for continent dropdown
	 */
	$("#continentSelect").on ("change", function () {
		jsonRequest ("api.php?data=countries&action=visitsbycountryfromcontinent&param=" + this.value,"#loadingCountry", 'Country', "#countryVisits");
	});
});

/*
 * Function that returns the data in a JSON request and displays loading gif
 */
function jsonRequest (url, loadingId, requestType, tableId) {
	console.log(requestType + '  ' + loadingId + ' - '+url);
	return (function () {
		var result = null;
		$.ajax({
			'async': true,
	        'global': false,
	        'url': url,
	        'dataType': "json",
			'beforeSend': function(){
				$(loadingId).show ();
				$(tableId).hide ();
			},
	        'success': function (data) {

				if(requestType=='Brand'){
					processBrandResults(data);
				} else if(requestType=='Country'){
					processCountryResults(data);
				} else if(requestType=='Browser'){
					processBrowserResults(data);
				} else if (requestType == 'BrandDropdown'){
					processBrandDropdown(data);
				} else if (requestType == 'CountryDropdown'){
					processCountryDropdown(data);
				}

				result = data;
	        }
		}).done(function(){
			$(loadingId).hide ();
			$(tableId).show ();
		});
		return result;
	})();
}

function jsonRequestForCounts (url) {
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

function processCountryDropdown(continentList){
	var continentResults = [];
	for (var i = 0; i < continentList.length; i++) {
		continentResults[continentList[i].ContinentCode] = continentList[i].ContinentName;
	}
	$("#continentSelect").html (createDropdown (continentResults, "ContinentCode", "ContinentName", "continentCode", "Continent", "continentSelect"));
}

function processBrandDropdown(brandList){
	var brandResults = [];
	for (var i = 0; i < brandList.length; i++) {
		brandResults[brandList[i].id] = brandList[i].name;
	}
	$("#brandSelect").html (createDropdown (brandResults, "id", "name", "brandId", "Brand", "brandSelect"));
}

function processBrowserResults(browserList){
	var browserResults = [];
	var totalVisits = 0.0;
	for (var i = 0; i < browserList.length; i++) {
		browserResults[browserList[i].name] = jsonRequestForCounts("api.php?data=Visits&action=countbybrowser&param=" + browserList[i].id);
		totalVisits += parseFloat (browserResults[browserList[i].name]);
	}
	for (var key in browserResults) {
		browserResults[key] = ((browserResults[key] / totalVisits) * 100).toFixed (2) + "%";
	}
	var browserHeaders = ["Browser", "Visits"];
	$("#browserVisits").html (createTable (browserHeaders, browserResults));
}

function processBrandResults(brandVisits){
	$("#brandVisits").html ("");
	var brandVisitResults = [];
	brandVisitResults [$("#brandSelect option:selected").text()] = brandVisits;
	var brandHeaders = ["Brand", "Visits"];
	$("#brandVisits").html (createTable (brandHeaders, brandVisitResults));
}

function processCountryResults(countryList){
	var countryResults = [];
	for (var i = 0; i < countryList.length; i++) {
		countryResults[countryList[i].CountryName] = countryList[i].Visits;
	}
	var countryHeaders = ["Country", "Visits"];
	$("#countryVisits").html (createTable (countryHeaders, countryResults));
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
   var listHtml = "";
   listHtml += "<option selected disabled value=\"\">Select " + selectName + "</option>";
   for (var key in dropdownarray) {
      optionValue = key;
      optionText = dropdownarray[key];
      listHtml += "<option value=\"" + optionValue + "\">" + optionText + "</option>";
   }
   listHtml += "</select>";
   return listHtml;
}