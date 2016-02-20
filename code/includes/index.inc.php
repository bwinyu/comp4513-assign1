<?php 
/*
 * Feb 23, 2016
 *
 * Baldwin Yu, Joseph Balatbat, Matt Grixti, Philip Young
 * COMP-4513 Assignment 1 - Admin Dashboard Hme Page - PHP Version
 *
 * This page is the back-end php code for the home page
 */

/*
 * Function that creates a table based on headers and data retrieved from database
 */
function createTable ($headers, $tableData) {
   $tableHtml = "<table class=\"mdl-data-table mdl-cell mdl-cell--12-col mdl-shadow--2dp\">";
   $tableHtml .= "<thead>";
   $tableHtml .= "<tr>";
   foreach ($headers as $header) {
      $tableHtml .= "<th class=\"mdl-data-table__cell--non-numeric\">$header</th>";
   }
   $tableHtml .= "</tr>";
   $tableHtml .= "<tbody>";
   foreach ($tableData as $key => $row) {
      $tableHtml .= "<tr>";
      $tableHtml .= "<td class=\"mdl-data-table__cell--non-numeric\">$key</td>";
      $tableHtml .= "<td class=\"mdl-data-table__cell--non-numeric\">$row</td>";
      $tableHtml .= "</tr>";
   }
   $tableHtml .= "</tbody>";
   $tableHtml .= "</table>";
   return $tableHtml;
}

/*
 * Function that creates a dropdown list with IDs as values and names as text
 */
function createDropdown ($dropdownarray, $arrayId, $arrayName, $selectGet, $selectName) {
   $listHtml = "<select name=\"$selectGet\">";
   $listHtml .= "<option value=\"\">Select $selectName</option>";
   foreach ($dropdownarray as $option) {
      $optionValue = $option->$arrayId;
      $optionText = $option->$arrayName;
      $listHtml .= "<option value=\"$optionValue\">$optionText</option>";
   }
   $listHtml .= "</select>";
   return $listHtml;
}

/*
 * Visits table gateway
 */
$visitsGateway = new VisitsTableGateway ($dbAdapter);

/*
 * Retrieves all visit information to be used for browser visits table
 */
$browserVisits = array ();
$browsersGateway = new BrowserTableGateway ($dbAdapter);
$results = $browsersGateway->findAll();
$totalVisits = 0;
foreach ($results as $result) {
   $browserVisits[$result->name] = $visitsGateway->countByBrowser($result->id);
   $totalVisits += $browserVisits[$result->name];
}
foreach ($browserVisits as $key => $value) {
   $browserVisits[$key] = round ($value / $totalVisits * 100, 2) . "%";
}
$browserHeaders = array ("Browser", "Visits");

/*
 * Retrieves all visit information for a specific brand
 */
$brandsGateway = new DeviceBrandTableGateway ($dbAdapter);
$brandList = $brandsGateway->findAll ();

if (isset ($_GET["brandId"]) && $_GET["brandId"] != "") {
   $brandId = $_GET["brandId"];
   $brand = $brandsGateway->findById ($brandId);
   $brandResults = array ($brand->name => $visitsGateway->countByDeviceBrand ($brandId));
   $brandHeaders = array ("Brand", "Visits");
}

/*
 * Retrieves all visit information for a specific continent
 */
$continentsGateway = new ContinentsTableGateway ($dbAdapter);
$continentList = $continentsGateway->findAll ();

if (isset ($_GET["continentCode"]) && $_GET["continentCode"] != "") {
   $continentCode = $_GET["continentCode"];
   $countriesGateway = new CountriesTableGateway ($dbAdapter);
   $countries = $countriesGateway->filterByContinentCode ($continentCode);
   $countryResults = array ();
   foreach ($countries as $result) {
      $countryResults[$result->CountryName] = $visitsGateway->countByCountryCode ($result->ISO);
   }
   $countryHeaders = array ("Country", "Visits");
}

?>