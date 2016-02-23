
<!--Loads JavaScript for Google Charts-->
google.charts.load('current', {packages: ['corechart' , 'geochart', 'bar']});

$(function() {

    $("#switchBarChartAxisBtn").hide();
    jsonRequest("api.php?data=countries&action=fetchcountrynamestop10visits", "", "", "countryList");

    $("#areaChartBtn").click(function() {
        var shortMonth = $("#areaChartMonth").val();
        jsonRequest("api.php?data=visits&action=countmonthbyday&param=" + shortMonth, "#areaChartLoad", "#areaChart", 'areaChart');
    })

    $("#geoChartBtn").click(function() {
        var shortMonth = $("#geoChartMonth").val();
        jsonRequest("api.php?data=countries&action=visitsbycountry&param=" + shortMonth, "#geoChartLoad", "#geoChart", 'geoChart');
    })

    $("#colChartBtn").click(function() {
        var countries = [];
        countries.push($("#colChartCountrySelect1").val());
        countries.push($("#colChartCountrySelect2").val());
        countries.push($("#colChartCountrySelect3").val());


        if($.inArray('Not Selected', countries) == -1 && !countriesEqual(countries)) {

            countriesParam = "";

            for (var i = 0; i < countries.length; i++) {
                countriesParam += countries[i] + ",";
            }
            countriesParam = countriesParam.slice(0, -1);

            jsonRequest("api.php?data=visits&action=visitsforbarchart&param=" + countriesParam, "#colChartLoad", "#colChart", 'colChart');
        }
        else {
            if($.inArray('Not Selected', countries) != -1){
                errorMsg("Please select all three countries.");
            }
            else{
                errorMsg("You cannot have two of the same countries selected.");
            }
        }
    })


    switchClick = false;
    $("#switchBarChartAxisBtn").click(function() {
        if (switchClick) {
            switchClick = false;
        } else {
            switchClick = true;
        }
        jsonRequest("api.php?data=visits&action=visitsforbarchart&param=" + countriesParam, "#colChartLoad", "#colChart", 'colChart');
    })

    function loadCountryDropdowns(countryList){
        $(".countrySelect").append ($('<option>', {
            text: 'Select a country',
            value: 'Not Selected'
        }));

        $.each(countryList, function(key, value) {
            $(".countrySelect").append ($('<option>', {
                text: countryList[key].CountryName,
                value: countryList[key].CountryName
            }));
        });
    }

    function drawAreaChart(jsonData) {

        var areaChartArrayData = [];
        areaChartArrayData.push(['Date', 'Visits']);

        for (var i = 1; i < jsonData.length; i++){
            var dateStr = jsonData[i].Date.split("-");

            var day = parseInt(dateStr[2]);
                areaChartArrayData.push([day, parseInt(jsonData[i].Visits)]);
            }


        var data = google.visualization.arrayToDataTable(areaChartArrayData);
        var currMonth = $("#areaChartMonth option:selected").text();
        var options = {
            title: currMonth + ' Visits',
            hAxis: {title: 'Day',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0},
            width: 900,
            height: 500
        };

        var chart = new google.visualization.AreaChart(document.getElementById('areaChart'));
        chart.draw(data, options);
    }

    function drawGeoChart(jsonData) {

        //var shortMonth = $("#geoChartMonth").val();
        //
        //var jsonData = jsonRequest("api.php?data=countries&action=visitsbycountry&param=" + shortMonth, "#geoChartLoad", "#geoChart");

        var geoChartArrayData = [];
        geoChartArrayData.push(['Country', 'Visits']);

        for (var i = 1; i < jsonData.length; i++){
            geoChartArrayData.push([jsonData[i].CountryName, parseInt(jsonData[i].Visits)]);
        }

        var data = google.visualization.arrayToDataTable(geoChartArrayData);

        var options = {width: 900, height: 500};

        var chart = new google.visualization.GeoChart(document.getElementById('geoChart'));

        chart.draw(data, options);
    }

    function drawColChart(jsonData){

            colChartArrayData = [];
            revChartArrayData = [];

            //build regular chart shown when chart it is pressed
            colChartArrayData.push(['Month', jsonData[0].CountryName, jsonData[1].CountryName, jsonData[2].CountryName]);

            for (var i = 0; i < jsonData.length; i+=3){
                colChartArrayData.push([jsonData[i].MonthName, parseInt(jsonData[i].Visits), parseInt(jsonData[i+1].Visits), parseInt(jsonData[i+2].Visits)]);
            }

            //build reverse chart when switch button is pressed
            revChartArrayData.push(['Country', jsonData[0].MonthName, jsonData[3].MonthName, jsonData[6].MonthName]);

            for (var i = 0; i < 3; i++){
                revChartArrayData.push([jsonData[i].CountryName, parseInt(jsonData[i].Visits), parseInt(jsonData[i+3].Visits), parseInt(jsonData[i+6].Visits)]);
            }


            if (switchClick) {
                var data = google.visualization.arrayToDataTable(revChartArrayData);
            } else {
                var data = google.visualization.arrayToDataTable(colChartArrayData);
            }


            var currYear = new Date().getFullYear();

            var options = {
                chart: {
                    title: 'Site Visits',
                    subtitle: currYear,
                },
                width: 900,
                height: 500
            };

            var chart = new google.charts.Bar(document.getElementById('colChart'));

            chart.draw(data, options);

            $("#switchBarChartAxisBtn").show();
        }

    function countriesEqual(countries){
        var equal = false;

        if(countries[0]==countries[2]){
            equal = true;
        }
        else{
            for(var i = 0; i<countries.length; i++){
                if((i+1)<= countries.length){
                    if(countries[i] == countries[i+1]){
                        equal=true;
                    }
                }
            }
        }
        return equal;
    }

    function jsonRequest (url, loadingId, chartId, requestType) {
        return (function () {
            var result = null;
            $.ajax({
                'async': true,
                'global': false,
                'url': url,
                'dataType': "json",
                'beforeSend': function(){
                    $(loadingId).show();
                    $(chartId).hide();
                },
                'success': function (data) {
                    switch(requestType) {
                        case 'areaChart':
                            google.charts.setOnLoadCallback(function() {drawAreaChart(data)});
                            break;
                        case 'geoChart':
                            google.charts.setOnLoadCallback(function() {drawGeoChart(data)});
                            break;
                        case 'colChart':
                            google.charts.setOnLoadCallback(function() {drawColChart(data)});
                            break;
                        case 'countryList':
                            loadCountryDropdowns(data);
                        default:

                    }
                    result = data;
                }
            }).done(function () {
                $(loadingId).hide();
                $(chartId).show();
            });
            return result;
        })();
    }

    function errorMsg(msg) {
        var snackbarContainer = document.querySelector('#snackbar-error');

        var data = {
            message: msg,
            timeout: 5000
        };
        snackbarContainer.MaterialSnackbar.showSnackbar(data);

    }


});



