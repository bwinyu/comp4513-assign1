/**
 * Created by Matt on 2/21/2016.
 */


$(function(){
    var data=[];
        $.get('http://localhost:63342/comp4513-assign1/code/api.php?data=countries',
    function(data){
        data.forEach(function(obj){
            data.append(obj.CountryName);
        });
        console.log(data);
    });
   // $('#country').easyAutocomplete(data);
});