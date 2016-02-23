
<!--Loads JavaScript for Google Charts-->
google.charts.load('current', {packages: ['corechart' , 'geochart', 'bar']});

$(function() {

    loadCountryDropdowns();

    $("#areaChartBtn").click(function() {
        google.charts.setOnLoadCallback(drawAreaChart);
        drawAreaChart();
    })

    $("#geoChartBtn").click(function() {
        google.charts.setOnLoadCallback(drawGeoChart);
        drawGeoChart();
    })

    $("#colChartBtn").click(function() {
        google.charts.setOnLoadCallback(drawColChart);
        drawColChart();
    })

    function loadCountryDropdowns(){
        $(".countrySelect").append ($('<option>', {
            text: 'Select a country',
            value: 'Not Selected'
        }));
        var countryList = jsonRequest("api.php?data=countries&action=fetchcountrynamestop10visits");
        $.each(countryList, function(key, value) {
            $(".countrySelect").append ($('<option>', {
                text: countryList[key].CountryName,
                value: countryList[key].CountryName
            }));
        });
    }

    function drawAreaChart() {
        var shortMonth = $("#areaChartMonth").val();

        var jsonData = jsonRequest("api.php?data=visits&action=countmonthbyday&param=" + shortMonth);

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
            vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('areaChart'));
        chart.draw(data, options);
    }

    function drawGeoChart() {
        var shortMonth = $("#geoChartMonth").val();

        var jsonData = jsonRequest("api.php?data=countries&action=visitsbycountry&param=" + shortMonth);

        var geoChartArrayData = [];
        geoChartArrayData.push(['Country', 'Visits']);

        for (var i = 1; i < jsonData.length; i++){
            geoChartArrayData.push([jsonData[i].CountryName, parseInt(jsonData[i].Visits)]);
        }

        var data = google.visualization.arrayToDataTable(geoChartArrayData);

        var options = {};

        var chart = new google.visualization.GeoChart(document.getElementById('geoChart'));

        chart.draw(data, options);
    }

    function drawColChart(){
        var countries = [];
        countries.push($("#colChartCountrySelect1").val());
        countries.push($("#colChartCountrySelect2").val());
        countries.push($("#colChartCountrySelect3").val());

        if($.inArray('Not Selected', countries) && !countriesEqual(countries)) {

            colChartArrayData = [];
            revChartArrayData = [];

            var countriesParam = "";

            for(var i = 0; i< countries.length; i++){
                console.log(countries[i]);
                countriesParam += countries[i] + ",";
            }
            countriesParam = countriesParam.slice(0, -1);

            var jsonData = jsonRequest("api.php?data=visits&action=visitsforbarchart&param=" + countriesParam);

            colChartArrayData.push(['Month', jsonData[0].CountryName, jsonData[1].CountryName, jsonData[2].CountryName]);
            revChartArrayData.push(['Country', jsonData[0].MonthName, jsonData[1].MonthName, jsonData[2].MonthName]);

            for (var i = 0; i < jsonData.length; i+=3){
                colChartArrayData.push([jsonData[i].MonthName, jsonData[i].Visits, jsonData[i+1].Visits, jsonData[i+2].Visits]);
            }

            var data = google.visualization.arrayToDataTable(colChartArrayData);

            var currYear = new Date().getFullYear();

            var options = {
                chart: {
                    title: 'Site Visits',
                    subtitle: currYear
                },
            };

            var chart = new google.charts.Bar(document.getElementById('colChart'));

            chart.draw(data, options);
        }
        else {
            if(countriesEqual(countries)){
                alert("You cannot have two of the same countries selected!");
            }
            else {
                alert("Please fill in all three countries");
            }
        }
    }

    function countriesEqual(countries){
        var equal = false;
        for(var i = 0; i<countries.length; i++){
            if((i+1)<= countries.length){
                if(countries[i] == countries[i+1]){
                    equal=true;
                }
            }
        }
        return equal;
    }

    function jsonRequest (url) {
        return (function () {
            var result = null;
            $.ajax({
                'async': false,
                'global': false,
                'url': url,
                'dataType': "json",
                'success': function (data) {
                    result = data;
                }
            });
            return result;
        })();
    }


});



