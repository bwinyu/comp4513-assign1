<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");

$actionFunction = array ();

foreach (glob("code/lib/model/*.php") as $filename)
{
    include $filename;
}
//include "code/lib/dataAccess/TableDataGateway.class.php";

function createJson($array, $attributes, $userAttr)
{
    $dataToJSON = array();

    if (is_null($userAttr) || $userAttr == "") {
        foreach ($attributes as $key) {
            foreach ($array as $row) {
                $dataToJSON[$key][] = (string)$row->$key;
                print_r($row->fieldValues);
            }
        }
    }
    else
    {
        if (in_array($userAttr, $attributes))
        {
            foreach($array as $row)
            {
                $dataToJSON[$userAttr][] = (string)$row->$userAttr;
            }
        }
        else
        {
            $dataToJSON = null;
        }
    }
    return json_encode($dataToJSON);
}


function pullData ($userData, $userAttr)
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
                echo createJson($array, $BrowserAttributes, $userAttr);
                break;
            case "Continents":
                $array = $ContinentsToPull->findAll();
                echo createJson($array, $ContinentsAttributes, $userAttr);
                break;
            case "Countries":
                $array =$CountriesToPull->findAll();
                echo createJson($array, $CountriesAttributes, $userAttr);
                break;
            case "DeviceBrand":
                $array = $DeviceBrandToPull->findAll();
                echo createJson($array, $DeviceBrandAttributes, $userAttr);
                break;
            case "DeviceType":
                $array = $DeviceTypeToPull->findAll();
                echo createJson($array, $DeviceTypeAttributes, $userAttr);
                break;
            case "OperatingSystems":
                $array = $OperatingSystemsToPull->findAll();
                echo createJson($array, $OperatingSystemsAttributes, $userAttr);
                break;
            case "Referrers":
                $array = $ReferrersToPull->findAll();
                echo createJson($array, $ReferrersAttributes, $userAttr);
                break;
            case "Visits":
                $array = $VisitsToPull->findAll();
                echo createJson($array, $VisitsAttributes, $userAttr);
                break;
        }
    }
}

function countData($userData, $actionType, $param)
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

    if (in_array($userData, $dataSets))
    {
        switch($userData)
        {
            case "Visits":
                if ($actionType == "countmonth")
                    $dataOutput = $VisitsToPull->countByMonth($param);
                elseif ($actionType == "countmonthbyday") {
                    $dataOutput = $VisitsToPull->visitsByDayForMonth($param);
                    $dataOutput = createJson($dataOutput, array("Visits","Date"), null);
                }
                else
                    echo null;
                echo json_encode($dataOutput);
                break;
        }
    }
}
?>

<?php
    if(isset($_GET['data']))
    {
        $data = $_GET['data'];
        $data = ucfirst($data);
        if(isset($_GET['action']))
        {
            $action = $_GET['action'];
            if(isset($_GET['param']))
            {

                $param = $_GET['param'];
                countData($data, $action, $param);
            }
        }
        else
        {
            if (!isset($_GET['attr']))
            {
                $attr = null;
            }
            else
            {
                $attr = $_GET['attr'];
            }
            echo $data;
            pullData($data, $attr);
        }

    }


?>

