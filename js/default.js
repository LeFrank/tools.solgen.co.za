
$(document).ready(function () {
    $(window).bind('scroll', function () {
        if ($(window).scrollTop() > 50) {
            $('.top-nav').addClass('fixed');
        } else {
            $('.top-nav').removeClass('fixed');
        }
    });
    $(document).foundation();
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

function showLoadingNotification() {

}

function hideLoadingNotification() {

}

var confirmOnPageExit = function (e)
{
    // If we haven't been passed the event get the window.event
    e = e || window.event;

    var message = 'There is unsaved work present, are you sure you wish to leave this page?';

    // For IE6-8 and Firefox prior to version 4
    if (e)
    {
        e.returnValue = message;
    }

    // For Chrome, Safari, IE8+ and Opera 12+
    return message;
};


function confirm_delete() {
    return confirm('This will delete the item, are you sure?');
}
