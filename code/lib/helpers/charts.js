
<!--Loads JavaScript for Google Charts-->
google.charts.load('current', {packages: ['corechart' , 'geochart', 'bar']});

$(function() {
    $("#areaChartBtn").click(function() {
        google.charts.setOnLoadCallback(drawAreaChart);
        drawAreaChart();
    })

    $("#geoChartBtn").click(function() {
        google.charts.setOnLoadCallback(drawGeoChart);
        drawAreaChart();
    })

    $("#barChartBtn").click(function() {
        google.charts.setOnLoadCallback(drawBarChart);
        drawBarChart();
    })

    function drawAreaChart() {
        var shortMonth = $("#areaChartMonth").val();

        var jsonData = jsonRequest("api.php?data=visits&action=countmonthbyday&param=" + shortMonth);

        var chartArrayData = [];
        chartArrayData[0] = [];
        chartArrayData[0, 0] = "Visits";
        chartArrayData[0, 1] = "Date";


        chartArrayData[1] = [];
        chartArrayData[1, 0] = "Visits";
        chartArrayData[1, 1] = "Date";

        console.log(chartArrayData);
        for (var i = 1; i < jsonData.length; i++){
                console.log(jsonData[i].Visits);
                chartArrayData[i, 0] = jsonData[i].Visits;
                chartArrayData[i, 1] = jsonData[i].Date;
            }


        var data = google.visualization.arrayToDataTable(chartArrayData);
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

        var data = google.visualization.arrayToDataTable([
            ['Country', 'Popularity'],
            ['Germany', 200],
            ['United States', 300],
            ['Brazil', 400],
            ['Canada', 500],
            ['France', 600],
            ['RU', 700]
        ]);

        var options = {};

        var chart = new google.visualization.GeoChart(document.getElementById('geoChart'));

        chart.draw(data, options);

    }

    function drawBarChart(){

        var data = google.visualization.arrayToDataTable([
            ['Year', 'Sales', 'Expenses', 'Profit'],
            ['2014', 1000, 400, 200],
            ['2015', 1170, 460, 250],
            ['2016', 660, 1120, 300],
            ['2017', 1030, 540, 350]
        ]);

        var fullDate = new Date();
        var currYear = fullDate.getFullYear();

        var options = {
            chart: {
                title: 'Site Visits',
                subtitle: "'" + currYear + "'",
            },
            bars: 'vertical' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barChart'));

        chart.draw(data, options);
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


        // ['Day', 'Visits'],
        //['2016-01-01',  197],
        //['2016-01-02',  211],
        //['2016-01-03',  194],
        //['2016-01-04',  213]
    function createChartsArray(headerArray, item1Array, item2Array, item3Array){



    }

});



