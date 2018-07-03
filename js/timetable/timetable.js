/* global eventsArray */

var formatDate = "yy-mm-dd";
var hasDataFor = {"earliestStartDate": moment(currentDateRange.startDate), "oldestEndDate": moment(currentDateRange.endDate)};
$(document).ready(function () {
    var events = eventsArray;


    $("#clearForm").click(function () {
        $("input[type=text], textarea").val("");
        $("#id").val("");
        $("input[type=checkbox]").attr("checked", false);
        $("#delete").hide();
        $("#clearForm").hide();
    });
    $(function () {
        $("#startDate").datetimepicker({
            onClose: function () {
                updateEndDate($("#startDate").val());
            }});
    });
    $(function () {
        $("#endDate").datetimepicker();
    });

    function updateEndDate(date) {
        if ($("#endDate").val() == "") {
            $("#endDate").attr("placeholder", date);
            $("#endDate").datetimepicker({
                startDate: date
            });
        }
    }

//    console.log(currentDateRange.startDate);
//    console.log(currentDateRange.endDate);

    var myCalendar;
    myCalendar = $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: $.formatDateTime(formatDate, new Date()),
        editable: true,
        events: eventsArray,
        eventColor: '#666666',
        eventTextColor: '#d8d8d8',
        fixedWeekCount: false,
        weekNumbers: true,
        eventRender: function (event, element) {
            element.qtip({
                content: event.description,
                position: {
                    my: 'top left', // Position my top left...
                    at: 'bottom left', // at the bottom right of...
                    target: $(element) // my target
                }
            });
        },
        eventClick: function (calEvent, jsEvent, view) {
            //TODO: use seperate function for this!
            setEventEdit(calEvent.id);
        },
        dayClick: function (date, jsEvent, view) {
            // change the day's background color just for fun
            // add some cool functionality;
            if ($(this).css('background-color') != 'rgb(221, 221, 221)') {
                $(this).css('background-color', '#ddd');
            } else {
                $(this).css('background-color', '#f8f8f8');
            }
        }
    }).on('click', '.fc-month-button', function () {
        $("#fcViewState").val("month");
    }).on('click', '.fc-agendaWeek-button', function () {
        $("#fcViewState").val("agendaWeek");
    }).on('click', '.fc-agendaDay-button', function () {
        $("#fcViewState").val("agendaDay");
    });

    if (typeof currentEvent !== 'undefined') {
        myCalendar.fullCalendar('gotoDate', currentEvent[0].start);
    }

    if ($("#fcViewState").val() != "") {
//        console.log($("#fcViewState").val());
        myCalendar.fullCalendar('changeView', $("#fcViewState").val());
    }

    $("#delete").click(function () {
        $.ajax({
            type: "GET",
            url: "/timetable/delete/" + $("#id").val()
        });
    });

    $('.fc-prev-button').click(function () {
        var currentView = $("#fcViewState").val();
        if (currentView == "" || currentView == "month") {
//            console.log("Get last months data");
            var activeMonthStartDate = moment(currentDateRange.startDate);
            var activeMonthEndDate = moment(currentDateRange.endDate);
            activeMonthStartDate = activeMonthStartDate.subtract(1, 'month');
            activeMonthEndDate = activeMonthEndDate.subtract(1, 'month');
            currentDateRange.startDate = activeMonthStartDate.format();
            currentDateRange.endDate = activeMonthEndDate.format();
            if (checkCache(activeMonthStartDate, activeMonthEndDate)) {
                //            console.log(activeMonthStartDate.format(), activeMonthEndDate.format());
                $.ajax({
                    type: "POST",
                    url: "/timetable/time-period/search/",
                    data: {
                        "startDate": activeMonthStartDate.format(),
                        "endDate": activeMonthEndDate.format()
                    },
                    dataType: "json"
                }).done(function (resp) {
//                    console.log(resp);
//                    console.log("getting more data");
                    myCalendar.fullCalendar('addEventSource', resp);
                });
            } else {

            }
        } else if (currentView == "agendaWeek") {
            console.log("Get next weeks data");
        } else if (currentView == "agendaDay") {
            console.log("Get next days data");
        }
    });


    $('.fc-next-button').click(function () {
        var currentView = $("#fcViewState").val();
        if (currentView == "" || currentView == "month") {
//            console.log("Get next months data");
            var activeMonthStartDate = moment(currentDateRange.startDate);
            var activeMonthEndDate = moment(currentDateRange.endDate);
            activeMonthStartDate = activeMonthStartDate.add(1, 'month');
            activeMonthEndDate = activeMonthEndDate.add(1, 'month');
            currentDateRange.startDate = activeMonthStartDate.format();
            currentDateRange.endDate = activeMonthEndDate.format();
            if (checkCache(activeMonthStartDate, activeMonthEndDate)) {
//                console.log("get the data");
                $.ajax({
                    type: "POST",
                    url: "/timetable/time-period/search/",
                    data: {
                        "startDate": activeMonthStartDate.format(),
                        "endDate": activeMonthEndDate.format()
                    },
                    dataType: "json"
                }).done(function (resp) {
//                    console.log(resp);
//                    console.log("getting more data");
                    myCalendar.fullCalendar('addEventSource', resp);
                });
            }
        } else if (currentView == "agendaWeek") {
            console.log("Get next weeks data");
        } else if (currentView == "agendaDay") {
            console.log("Get next days data");
        }
    });

    $("#timetableRepetition").change(function () {
        var reps = $("#numberOfRepeats");
        var repsDesc = $("#repeatDescriptor");
        if ($(this).val() == "0") {
            reps.prop("disabled", true);
            repsDesc.html("");
        } else {
            reps.prop("disabled", false);
        }
        switch ($(this).val()) {
            case "0":
                reps.val("0");
                break;
            case "2" : //weekly
                reps.val("5");
                repsDesc.html("week(s)");
                break;
            case "3" : //fortnightly
                reps.val("2");
                repsDesc.html("fortnight(s)");
                break;
            case "4": // annually
                reps.val("10");
                repsDesc.html("year(s)");
                break;
            case "5": // months
                reps.val("2");
                repsDesc.html("month(s)");
                break;
            case "6": // Mon/Wed/Fri
                reps.val("4");
                repsDesc.html("set(s)");
                break;
            case "7": // Tue/Thur
                reps.val("4");
                repsDesc.html("set(s)");
                break;
            case "8" : //week days
                reps.val("4");
                repsDesc.html("sets of week day(s)");
                break;
            case "9": //weekend
                reps.val("4");
                repsDesc.html("weekend(s)");
                break;
            case "10": //daily
                reps.val("5");
                repsDesc.html("day(s)");
                break;
            default:
                reps.val("0");
                repsDesc.html("");
                break;
        }
    });
    CKEDITOR.replace('description');

    var now = moment();
    for (var i = 0; i <= events.length; i++) {
        var event = events[i];
//        console.log(event["start"]);
        var day = moment(event["start"], "YYYY-MM-DD HH:mm");
        if (day.isSame(now.format(), 'day') && now.diff(day) < 0) {
            console.log(event.start);
            console.log(now.diff(day));
            console.log(day.diff(now));
            console.log(event);
            var t = event.title;
            var d = event.description;
            setTimeout(function () {
                notifyMe(t,d);
            }, day.diff(now));
        }
    }
});

function setEventEdit(eventId) {
//    console.log("Clicked!! ");
    $.ajax({
        type: "GET",
        url: "/timetable/view/" + eventId
    }).done(function (resp) {
        if (resp != "[]") {
            var obj = $.parseJSON(resp);
            $("#id").val(obj.id);
            $("#name").val(obj.name);
            $("#description").html(obj.description);
            CKEDITOR.instances['description'].setData(obj.description);
            if (obj.all_day_event == 1) {
                $("#allDayEvent").prop('checked', true);
            } else {
                $("#allDayEvent").prop("checked", false);
            }
            $("#startDate").val(obj.start_date);
            $("#endDate").val(obj.end_date);
            $("#timetableCategory").val(obj.tt_category_id).prop('selected', true);
            $("#timetableExpenseType").val(obj.expense_type_id).prop('selected', true);
            $("#locationId").val(obj.location_id).prop('selected', true);
            $("#location").val(obj.location_text);
            $("#clearForm").show();
            $("#delete").attr("href", "/timetable/delete/" + obj.id);
            $("#delete").show();
        }
    });
}


function checkCache(startDate, endDate) {
    var getData = false;
    if (startDate.isBefore(hasDataFor.earliestStartDate)) {
//           console.log(startDate.format() + " is before " + hasDataFor.earliestStartDate.format());
        getData = true;
        hasDataFor.earliestStartDate = startDate;
//           console.log(hasDataFor);
    }
    if (endDate.isAfter(hasDataFor.oldestEndDate)) {
//           console.log(endDate.format() + " is after " + hasDataFor.oldestEndDate.format());
        getData = true;
        hasDataFor.oldestEndDate = endDate;
//           console.log(hasDataFor);
    }
    return getData;
}

function notifyMe(title,description) {
    var options = {
        body: description,
        requireInteraction: true
    }
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
    }

    // Let's check whether notification permissions have already been granted
    else if (Notification.permission === "granted") {
        // If it's okay let's create a notification
        var notification = new Notification(title,options);
    }

    // Otherwise, we need to ask the user for permission
    else if (Notification.permission !== "denied") {
        Notification.requestPermission(function (permission) {
            // If the user accepts, let's create a notification
            if (permission === "granted") {
                var notification = new Notification(title,options);
            }
        });
    }
}