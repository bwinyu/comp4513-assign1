
<!--Loads JavaScript for Google Charts-->
google.charts.load('current', {packages: ['corechart' , 'geochart']});
$(function() {
    $("#areaChartBtn").click(function() {
        google.charts.setOnLoadCallback(drawAreaChart);
        drawAreaChart();
    })

    $("#geoChartBtn").click(function() {
        google.charts.setOnLoadCallback(drawGeoChart);
        drawAreaChart();
    })

    function drawAreaChart() {
        //$.get( "code/api.php", function( data ) {
        //    $( ".result" ).html( data );
        //    alert( "Load was performed." );
        //});
        var data = google.visualization.arrayToDataTable([
            ['Day', 'Visits'],
            ['2016-01-01',  197],
            ['2016-01-02',  211],
            ['2016-01-03',  194],
            ['2016-01-04',  213]
        ]);
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
});



