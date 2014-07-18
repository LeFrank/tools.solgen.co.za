$(document).ready(function() {
    Handlebars.registerHelper('time', function(dateTime) {
        var formatDate = "hh:ii";
        return $.formatDateTime(formatDate, new Date(dateTime * 1000));
    });
    Handlebars.registerHelper('date', function(dateTime) {
        var formatDate = "DD, d MM yy";
        return $.formatDateTime(formatDate, new Date(dateTime * 1000));
    });
    Handlebars.registerHelper('for', function(dateTime) {
        //var formatDate = "yy/mm/dd gg:ii";
        var formatDate = "hh:ii";
        return $.formatDateTime(formatDate, new Date(dateTime * 1000));
    });
    
    Handlebars.registerHelper('getMeasurementVal',function(){
        var resp = "";
        if(weatherSetting.measurement == 'metric'){
            resp = measure.metric; 
        }else{
            resp = measure.imperial; 
        }
        return resp;
    });
});


function viewTodaysWeatherFor(locationId) {
    // get Location data
    var templateSource = "";
    $.ajax({
        type: "GET",
        url: "/js/weather/template/single-day.handlebars"
    }).done(function(respon) {
        templateSource = respon;
        $.ajax({
            type: "POST",
            url: "/weather/today/",
            data: {"locationId": locationId}
        }).done(function(resp) {
            var obj = $.parseJSON(resp);
            var source = templateSource;
            var template = Handlebars.compile(source);
            var data = obj;
            var txt = template(data);
            $("#weatherLocationDetails").html(txt).show();
        });
    });
}

function viewSevenDayForecastFor(locationId) {
    // get Location data
    var templateSource = "";
    $.ajax({
        type: "GET",
        url: "/js/weather/template/seven-day.handlebars"
    }).done(function(respon) {
        templateSource = respon;
        $.ajax({
            type: "POST",
            url: "/weather/forecast/",
            data: {"locationId": locationId}
        }).done(function(resp) {
            var obj = $.parseJSON(resp);
            var source = templateSource;
            var template = Handlebars.compile(source);
            var data = obj;
            var txt = template(data);
            $("#weatherLocationDetails").html(txt).show();
            $("#locationName").html(obj.location.name);
        });
    });
}