/**
 * Created by Matt on 2/21/2016.
 */


$(function(){
    var options={
        data: [],
        list: {
            match: {
                enabled: true
            }
        },
        theme: "square"
    };

    $.get('api.php?data=countries&action=fetchcountrynames',
        function(data){
            data.forEach(function(obj){
                options.data.push(obj.CountryName);
            });

            $('#country').easyAutocomplete(options);
        });

    $('#filters').change(function(){

        var url ='api.php?data=visits&action=filtervisitsdata';
        var param = '&param=';
        var param2= '&param2=';
        var hasParam = false;

        $(".select").each(function(){
            var col = $(this).attr('id');
            var val = $(this).find(":selected").attr('value');

            if(val != 0){
                hasParam = true;
                param+=col + ',';
                param2+=val + ',';
            }
        });


        var country = $('#country').val();

        if(country != '') {
            hasParam = true;
            param += 'Country,';
            param2 += country + ',';
        }
        if(hasParam){
            param = param.substring (0, param.length - 1);
            param2 =  param2.substring (0, param2.length - 1);
            url+=param + param2;
        }

        console.log(url);
        /*
         * Fetch all visit information based on filters
         */
       jsonRequest (url);

    })


});


/*
 * Function that generates dialog information
 */
function createDialog (visitData) {
    var visitHtml = "<span class=\"close\" id=\"visitClose\">x</span>";
    visitHtml += "<p><b>Visit Date: </b>" + visitData.Date + "</p>";
    visitHtml += "<p><b>Visit Time: </b>" + visitData.Time + "</p>";
    visitHtml += "<p><b>IP Address: </b>" + visitData.ip_address + "</p>";
    visitHtml += "<p><b>Country: </b>" + visitData.Country + "</p>";
    visitHtml += "<p><b>Device Type: </b>" + visitData.DeviceType + "</p>";
    visitHtml += "<p><b>Brand: </b>" + visitData.DeviceBrand + "</p>";
    visitHtml += "<p><b>Browser: </b>" + visitData.Browser + "</p>";
    visitHtml += "<p><b>Referrer: </b>" + visitData.Referrer + "</p>";
    visitHtml += "<p><b>Operating System: </b>" + visitData.OS + "</p>";
    return visitHtml;
}

/*
 * Function that generates a table with visits information
 */
function createTable (headers, tableData) {
    var tableHtml = "<table id=\"visitsTable\" class=\"mdl-data-table mdl-cell mdl-cell--12-col mdl-shadow--2dp\">";
    tableHtml += "<thead>";
    tableHtml += "<tr>";
    for (var i = 0; i < headers.length; i++) {
        tableHtml += "<th class=\"mdl-data-table__cell--non-numeric\">" + headers[i] + "</th>";
    }
    tableHtml += "</tr>";
    tableHtml += "<tbody>";
    for (var row in tableData) {
        if (tableData[row].id != undefined) {
            tableHtml += "<tr>";
            tableHtml += "<td class=\"mdl-data-table__cell--non-numeric\">" + tableData[row].Date + "</td>";
            tableHtml += "<td class=\"mdl-data-table__cell--non-numeric\">" + tableData[row].Time + "</td>";
            tableHtml += "<td class=\"mdl-data-table__cell--non-numeric\">" + tableData[row].ip_address + "</td>";
            tableHtml += "<td class=\"mdl-data-table__cell--non-numeric\">" + tableData[row].Country + "</td>";
            tableHtml += "<td><button id=\"" + tableData[row].id + "\" class=\"rowButton mdl-button mdl-js-button mdl-button--raised\">More</button></td>";
            tableHtml += "</tr>";

        }
    }
    tableHtml += "</tbody>";
    tableHtml += "</table>";
    return tableHtml;
}

/*
 * Function that returns the data in a JSON request
 */
function jsonRequest (url) {

        var result = null;
        $.ajax({
            'async': true,
            'url': url,
            'dataType': "json",
            'ifModified': true,
            'beforeSend': function(){
                $('#loadingBar').show();
                $('#visits').hide();
            },
            'success': function (data) {
                processResults(data);
                $('#visits').show();
            }
        }).done(function () {
            $('#loadingBar').hide();
        });

    }

function processResults(visitResults){
    for (var result in visitResults) {
        visitResults[visitResults[result].id] = visitResults[result];
    }
    var visitHeaders = ["Visit Date", "Visit Time", "IP Address", "Country", ""];
    $("#visits").html (createTable (visitHeaders, visitResults));

    /*
     * When a button is clicked for a result, show the modal with info using the visit id
     */
    $(".rowButton").on ("click", function () {
        $("#visitModal").css ("display", "block");
        $("#visitContent").html (createDialog (visitResults[this.id]));
        $("#visitClose").on ("click", function () {
            $("#visitModal").css ("display", "none");
        });
    });
}
