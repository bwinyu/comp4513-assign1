<?php
/*
 * Feb 23, 2016
 *
 * Baldwin Yu, Joseph Balatbat, Matt Grixti, Philip Young
 * COMP-4513 Assignment 1 - Admin Dashboard Visits Browser Include Page
 *
 * This page is the back-end php code for the visits browser page
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
    $listHtml = "<select class=\"select\" id=\"$selectGet\">";
    $listHtml .= "<option  value=\"0\">Select $selectName</option>";
    foreach ($dropdownarray as $option) {
        $optionValue = $option->$arrayId;
        $optionText = $option->$arrayName;
        $listHtml .= "<option value=\"$optionText\">$optionText</option>";
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


/*
 * Retrieves all device type
 */
$typesGateway = new DeviceTypesTableGateway ($dbAdapter);
$typesList = $typesGateway->findAll();

/*
 * Retrieves all visit information for a specific brand
 */
$brandsGateway = new DeviceBrandTableGateway ($dbAdapter);
$brandList = $brandsGateway->findAll ();


$browsersGateway = new BrowserTableGateway ($dbAdapter);
$browserList = $browsersGateway->findAll();

$referrerGateway = new ReferrersTableGateway ($dbAdapter);
$referrerList = $referrerGateway->findAll();

$operatingSystemGateway = new OperatingSystemsTableGateway($dbAdapter);
$osList = $operatingSystemGateway->findAll();


?>