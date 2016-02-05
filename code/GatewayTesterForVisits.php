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



// all done close connection
$dbAdapter->closeConnection();

?>