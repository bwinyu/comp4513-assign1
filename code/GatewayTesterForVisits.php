<?php
/*
   Use this page to test each one of your table gateway classes.
*/

require_once('lib/helpers/visits-setup.inc.php');
?>

<html>
<body>
<h1> Table Gateways Tester </h1>

<?php

echo '<hr/>';
echo '<h2>Test BrowserTableGateway</h2>';
echo '<h3>Test findAll()</h3>';
$gate = new BrowserTableGateway($dbAdapter);
$result = $gate->findAll();
foreach ($result as $row)
{
   echo $row->id . " - " . $row->name . "<br/>";
}

echo '<h3>Test findById(3)</h3>';
$result = $gate->findById(3);
echo $result->id . " - " . $result->name;
  


echo '<hr/>';
echo '<h2>Test DeviceBrandTableGateway</h2>';
echo '<h3>Test findAllSorted()</h3>';
$gate = new DeviceBrandTableGateway($dbAdapter);
$result = $gate->findAllSorted(true);
foreach ($result as $row)
{
   echo $row->id . " - " . $row->name . "<br/>";
}

echo '<h3>Test findById(11)</h3>';
$result = $gate->findById(11);
echo $result->id . " - " . $result->name;

//Test for Continents
echo '<hr/>';
echo '<h2>Test ContinentsTableGateway</h2>';

echo '<h3>Test findAllSorted()</h3>';
$gate = new ContinentsTableGateway($dbAdapter);
$result = $gate->findAllSorted(true);
foreach ($result as $row) {
    echo $row->ContinentCode . " - " . $row->ContinentName . "<br/>";
}

echo '<h3>Test findById(OC)</h3>';
$result = $gate->findById('OC');
echo $result->ContinentCode . " - " . $result->ContinentName;


//Test for Countries
echo '<hr/>';
echo '<h2>Test CountriesTableGateway</h2>';

echo '<h3>Test findAllSorted()</h3>';
$gate = new CountriesTableGateway($dbAdapter);
$result = $gate->findAllSorted(true);
foreach ($result as $row) {
    echo $row->ISO . " - " . $row->CountryName . "<br/>";
}

echo '<h3>Test findById(BF)</h3>';
$result = $gate->findById('BF');
echo $result->ISO . " - " . $result->CountryName;

//Test for DeviceTypes
echo '<hr/>';
echo '<h2>Test DeviceTypesTableGateway</h2>';

echo '<h3>Test findAllSorted()</h3>';
$gate = new DeviceTypesTableGateway($dbAdapter);
$result = $gate->findAllSorted(true);
foreach ($result as $row) {
    echo $row->id . " - " . $row->name . "<br/>";
}

echo '<h3>Test findById(3)</h3>';
$result = $gate->findById(3);
echo $result->id . " - " . $result->name;

//Test for OperatingSystems
echo '<hr/>';
echo '<h2>Test OperatingSystemsTableGateway</h2>';

echo '<h3>Test findAllSorted()</h3>';
$gate = new OperatingSystemsTableGateway($dbAdapter);
$result = $gate->findAllSorted(true);
foreach ($result as $row) {
    echo $row->id . " - " . $row->name . "<br/>";
}

echo '<h3>Test findById(3)</h3>';
$result = $gate->findById(3);
echo $result->id . " - " . $result->name;


//Test for Referrers
echo '<hr/>';
echo '<h2>Test ReferrersTableGateway</h2>';

echo '<h3>Test findAllSorted()</h3>';
$gate = new ReferrersTableGateway($dbAdapter);
$result = $gate->findAllSorted(true);
foreach ($result as $row) {
    echo $row->id . " - " . $row->name . "<br/>";
}

echo '<h3>Test findById(3)</h3>';
$result = $gate->findById(3);
echo $result->id . " - " . $result->name;

//Test for Visits
echo '<hr/>';
echo '<h2>Test VisitsTableGateway</h2>';

echo '<h3>Test findAllSorted()</h3>';
$gate = new VisitsTableGateway($dbAdapter);
$result = $gate->filterByCountryCode('BF');
foreach ($result as $row) {
    echo $row->id . " - " . $row->ip_address . "<br/>";
}

echo '<h3>Test findById(3)</h3>';
$result = $gate->findById(3);
echo $result->id . " - " . $result->ip_address;



// all done close connection
$dbAdapter->closeConnection();

?>