<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");

foreach (glob("code/lib/model/*.php") as $filename)
{
    include $filename;
}

function createJson($array, $attributes)
{
    $dataToJSON = array();

    foreach($attributes as $key)
    {
        if ($key != "PostalCodeFormat" || $key != "PostalCodeRegex")
        foreach ($array as $row)
        {
            $dataToJSON[$key][]= (string)$row->$key;
        }
    }

    return json_encode($dataToJSON);
}

function pullData ($userData)
{
    require_once('lib/helpers/visits-setup.inc.php');
    $BrowsersToPull = new BrowserTableGateway($dbAdapter);
    $BrowserAttributes = Browser::getFieldNames();
    $ContinentsToPull = new ContinentsTableGateway($dbAdapter);
    $ContinentsAttributes = Continents::getFieldNames();
    $CountriesToPull = new CountriesTableGateway($dbAdapter);
    $CountriesAttributes = Countries::getFieldNames();
    $DeviceBrandToPull = new DeviceBrandTableGateway($dbAdapter);
    $DeviceBrandAttributes = DeviceBrand::getFieldNames();
    $DeviceTypeToPull = new DeviceTypesTableGateway($dbAdapter);
    $DeviceTypeAttributes = DeviceTypes::getFieldNames();
    $OperatingSystemsToPull = new OperatingSystemsTableGateway($dbAdapter);
    $OperatingSystemsAttributes = OperatingSystems::getFieldNames();
    $ReferrersToPull = new ReferrersTableGateway($dbAdapter);
    $ReferrersAttributes = Referrers::getFieldNames();
    $VisitsToPull = new VisitsTableGateway($dbAdapter);
    $VisitsAttributes = Visits::getFieldNames();

    $dataSets = array("Browsers", "Continents", "Countries", "DeviceBrand", "DeviceType", "OperatingSystems", "Referrers", "Visits");
    if ( in_array($userData, $dataSets) )
    {
        switch($userData)
        {
            case "Browsers":
                $array = $BrowsersToPull->findAll();
                echo createJson($array, $BrowserAttributes);
                break;
            case "Continents":
                $array = $ContinentsToPull->findAll();
                echo createJson($array, $ContinentsAttributes);
                break;
            case "Countries":
                $array =$CountriesToPull->findAll();
                echo createJson($array, $CountriesAttributes);
                break;
            case "DeviceBrand":
                $array = $DeviceBrandToPull->findAll();
                echo createJson($array, $DeviceBrandAttributes);
                break;
            case "DeviceType":
                $array = $DeviceTypeToPull->findAll();
                echo createJson($array, $DeviceTypeAttributes);
                break;
            case "OperatingSystems":
                $array = $OperatingSystemsToPull->findAll();
                echo createJson($array, $OperatingSystemsAttributes);
                break;
            case "Referrers":
                $array = $ReferrersToPull->findAll();
                echo createJson($array, $ReferrersAttributes);
                break;
            case "Visits":
                $array = $VisitsToPull->findAll();
                echo createJson($array, $VisitsAttributes);
                break;
        }
    }
}
?>

<?php
    $data = $_GET['data'];
    pullData($data);
?>

