
$(document).ready(function () {
    $(window).bind('scroll', function () {
        if ($(window).scrollTop() > 50) {
            $('.top-nav').addClass('fixed');
        } else {
            $('.top-nav').removeClass('fixed');
        }
    });
    $(document).foundation();
    var toggler = document.getElementsByClassName("caret");
    var i;

    for (i = 0; i < toggler.length; i++) {
        toggler[i].addEventListener("click", function () {
            this.parentElement.querySelector(".nested").classList.toggle("active");
            this.classList.toggle("caret-down");
        });
    }
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


var delay = (function () {
    var timer = 0;
    return function (callback, ms) {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
    };
})();


// Get the button:
let scrollToTopBtn = document.getElementById("ScrollToTopBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    // scrollToTopBtn.style.display = "block";
    $('#ScrollToTopBtn').fadeIn();
  } else {
    // scrollToTopBtn.style.display = "none";
    $('#ScrollToTopBtn').fadeOut();
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
