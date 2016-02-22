<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
error_reporting(E_ALL & ~E_NOTICE); ini_set('display_errors', '1');

$actionFunction = array ();

foreach (glob("code/lib/model/*.php") as $filename)
{
    include $filename;
}
//include "code/lib/dataAccess/TableDataGateway.class.php";

function createJson($array, $attributes, $userAttr)
{
    $dataToJSON = $array;
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


    $dataSets = array("Browsers", "Continents", "Countries", "Devicebrand", "Devicetype", "Operatingsystems", "Referrers", "Visits");
    if ( in_array($userData, $dataSets) )
    {
        switch($userData)
        {
            case "Browsers":
                $array = $BrowsersToPull->findAll();
                echo json_encode($array);
                break;
            case "Continents":
                $array = $ContinentsToPull->findAll();
                echo json_encode($array);
                break;
            case "Countries":
                $array =$CountriesToPull->findAll();
                echo json_encode($array);
                break;
            case "Devicebrand":
                $array = $DeviceBrandToPull->findAll();
                echo json_encode($array);
                break;
            case "Devicetype":
                $array = $DeviceTypeToPull->findAll();
                echo json_encode($array);
                break;
            case "Operatingsystems":
                $array = $OperatingSystemsToPull->findAll();
                echo json_encode($array);
                break;
            case "Referrers":
                $array = $ReferrersToPull->findAll();
                echo json_encode($array);
                break;
            case "Visits":
                $array = $VisitsToPull->findAll();
                echo json_encode($array);
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
                }
				elseif($actionType == "countbycountrycode")
				{
					$dataOutput = $VisitsToPull->countByCountryCode($param);
					
				}
				elseif($actionType == "countbydevicetype")
				{
					$dataOutput = $VisitsToPull->countByDeviceType($param);
				}
				elseif($actionType == "countbydevicebrand")
				{
					$dataOutput = $VisitsToPull->countByDeviceBrand($param);
				}
				elseif($actionType == "countbybrowser")
				{
					$dataOutput = $VisitsToPull->countByBrowser($param);
				}
				elseif($actionType == "countbyreferrer")
				{
					$dataOutput = $VisitsToPull->countByReferrer($param);
				}
				elseif($actionType == "countbyos")
				{
					$dataOutput = $VisitsToPull->countByOS($param);
				}
                else
                    echo null;
                echo json_encode($dataOutput);
                break;
            case "Countries":
                if($actionType == "filterbycontinentcode")
                {
                    $dataOutput = $CountriesToPull->filterByContinentCode($param);
                    echo json_encode($dataOutput);
                    break;
                }
                elseif ($actionType == "countrieslike")
                {
                    $dataOutput = $CountriesToPull->countryLike($param);
                    echo json_encode($dataOutput);
                    break;
                }
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
            pullData($data);
        }

    }


?>

