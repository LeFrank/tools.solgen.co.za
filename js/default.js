
$(document).ready(function() {
    $(window).bind('scroll', function () {
    if ($(window).scrollTop() > 50) {
        $('.top-nav').addClass('fixed');
    } else {
        $('.top-nav').removeClass('fixed');
    }
});
});
function getObjects(obj, key, val) {
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i))
            continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(getObjects(obj[i], key, val));
        } else if (i == key && obj[key] == val) {
            objects.push(obj);
        }
    }
    return objects;
}

function showLoadingNotification(){
        
}

function hideLoadingNotification(){
    
}