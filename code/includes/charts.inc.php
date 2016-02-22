<?php
function createMonthDropdown($id){
    $monthDropDown = "<select id=\"$id\">";

    for ($m=1; $m<=12; $m++) {
        $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
        $monthDropDown .= "<option value='" . date('M', strtotime($month . '01'))."'>".$month."</option>";
    }

    $monthDropDown .= "</select>";

    return $monthDropDown;
}

function createDropdown($dropdownarray, $id, $selectName) {
    $listHtml = "<select id=\"$id\">";
    $listHtml .= "<option value=\"\">Select $selectName</option>";
    foreach ($dropdownarray as $option) {
        $listHtml .= "<option value=\"$option.CountryName\">$option.CountryName</option>";
    }
    $listHtml .= "</select>";
    return $listHtml;
}
?>