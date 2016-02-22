<?php
/*
 * Feb 23, 2016
 *
 * Baldwin Yu, Joseph Balatbat, Matt Grixti, Philip Young
 * COMP-4513 Assignment 1 - Admin Dashboard Web Service API
 *
 * This php file handles all of the php requests
 */

header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
//import all required files
foreach (glob("code/lib/model/*.php") as $filename)
{
    include $filename;
}
//used to output raw data from the table (no filters)
function pullData ($userData)
{
    require_once('lib/helpers/visits-setup.inc.php');
    $BrowsersToPull = new BrowserTableGateway($dbAdapter);
    $ContinentsToPull = new ContinentsTableGateway($dbAdapter);
    $CountriesToPull = new CountriesTableGateway($dbAdapter);
    $DeviceBrandToPull = new DeviceBrandTableGateway($dbAdapter);
    $DeviceTypeToPull = new DeviceTypesTableGateway($dbAdapter);
    $OperatingSystemsToPull = new OperatingSystemsTableGateway($dbAdapter);
    $ReferrersToPull = new ReferrersTableGateway($dbAdapter);
    $VisitsToPull = new VisitsTableGateway($dbAdapter);


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
//used to pull data with special requirements or data that uses methods with complex joins to pull data
//  query string format = data=(country)&action(function name)&param1()&param2()
function actionData($userData, $actionType, $param, $param2)
{
    require_once('lib/helpers/visits-setup.inc.php');
    $BrowsersToPull = new BrowserTableGateway($dbAdapter);
    $CountriesToPull = new CountriesTableGateway($dbAdapter);
    $VisitsToPull = new VisitsTableGateway($dbAdapter);
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
                elseif ($actionType == "filtervisitsdata")
                {
                    $dataOutput = $VisitsToPull->filterVisitsData($param, $param2);
                }
                elseif ($actionType == "visitsforbarchart")
                {
                    $dataOutput = $VisitsToPull->visitsForBarChart($param);
                }
                else
                    $dataOutput = null;
                echo json_encode($dataOutput);
                break;
            case "Countries":
                if($actionType == "filterbycontinentcode")
                {
                    $dataOutput = $CountriesToPull->filterByContinentCode($param);
                }
                elseif ($actionType == "countrieslike")
                {
                    $dataOutput = $CountriesToPull->countryLike($param);
                }
                elseif ($actionType == "visitsbycountry")
                {
                    $dataOutput = $CountriesToPull->visitsByCountry($param);
                }
                elseif ($actionType == "fetchcountrynames")
                {
                    $dataOutput = $CountriesToPull->fetchCountryNames();
                }
                elseif ($actionType == "fetchcountrynamestop10visits")
                {
                    $dataOutput = $CountriesToPull->fetchCountryNamesTop10Visits();
                }
                elseif ($actionType == "visitsbycountryfromcontinent")
                {
                    $dataOutput = $CountriesToPull->visitsByCountryFromContinent($param);
                }
                else
                    $dataOutput = "Invalid Input";
                echo json_encode($dataOutput);
            break;
            case "Browsers":
                if($actionType == "visitsbybrowser")
                {
                    $dataOutput = $BrowsersToPull->visitsByBrowser();
                }
                else
                    $dataOutput = "Invalid Input";
                echo json_encode($dataOutput);
                break;
        }
    }
}
?>

<?php
//used to check the query string for data
    if(isset($_GET['data']))
    {
        $data = $_GET['data'];
        $data = ucfirst($data);
        if(isset($_GET['action']))
        {
            $action = $_GET['action'];
            if (!isset($_GET['param']) || $_GET['param'] == "")
            {
                if (isset($_GET['param2']))
                {
                    echo json_encode("Invalid Parameter values");
                }
                else{
                    actionData($data, $action, null, null);
                }
            }
            elseif((isset($_GET['param']) && (!isset($_GET['param2'])) ))
            {
                $param = $_GET['param'];
                $pos = strpos($param, ',');
                if ($pos !== false)
                {
                    $param = explode(',', $param);
                }
                actionData($data, $action, $param, null);
            }

            else if (isset($_GET['param2']))
            {
                $param = $_GET['param'];
                $param2 = $_GET['param2'];
                $param = explode(',', $param);
                $param2 = explode(',', $param2);
                actionData($data, $action, $param, $param2);
            }
        }
        else
            pullData($data);
    }


?>

