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

    $.get('http://localhost:63342/comp4513-assign1/code/api.php?data=countries&action=fetchcountrynames',
        function(data){
            data.forEach(function(obj){
                options.data.push(obj.CountryName);
            });

            $('#country').easyAutocomplete(options);
        });

    $('#filters').change(function(){

        var url ='http://localhost:63342/comp4513-assign1/code/api.php?data=visits&action=filtervisitsdata&param=Country&param2=Canada';

        $.get(url, function(data){
            console.log(data);
        });
    })


});