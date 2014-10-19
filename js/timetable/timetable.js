var formatDate = "yy-mm-dd";
$(document).ready(function() {
    $("#clearForm").click(function() {
        $("input[type=text], textarea").val("");
        $("#id").val("");
        $("input[type=checkbox]").attr("checked", false);
        $("#delete").hide();
        $("#clearForm").hide();
    });
    $(function() {
        $("#startDate").datetimepicker();
    });
    $(function() {
        $("#endDate").datetimepicker();
    });

    var myCalendar;
    myCalendar = $('#calendar').fullCalendar({
        defaultDate: $.formatDateTime(formatDate, new Date()),
        editable: true,
        events: eventsArray,
        eventColor: '#666666',
        eventTextColor: '#d8d8d8',
        eventRender: function(event, element) {
            element.qtip({
                content: event.description
            });
        },
        eventClick: function(calEvent, jsEvent, view) {
            $.ajax({
                type: "GET",
                url: "/timetable/view/" + calEvent.id
            }).done(function(resp) {
                if (resp != "[]") {
                    var obj = $.parseJSON(resp);
                    $("#id").val(obj[0].id);
                    $("#name").val(obj[0].name);
                    $("#description").html(obj[0].description);

                    if(obj[0].all_day_event == 1){
                        console.log("check");
                        $("#allDayEvent").prop('checked',true);
                    }else{
                        console.log("uncheck");
                        $("#allDayEvent").prop("checked",false);
                    }
                    $("#startDate").val(obj[0].start_date);
                    $("#endDate").val(obj[0].end_date);
                    $("#timetableCategory").val(obj[0].tt_category_id).prop('selected', true);
                    $("#timetableExpenseType").val(obj[0].expense_type_id).prop('selected', true);
                    $("#timetableLocation").val(obj[0].location_id).prop('selected', true);
                    $("#locationText").val(obj[0].location_text);
                    $("#clearForm").show();
                    $("#delete").attr("href", "/timetable/delete/" + obj[0].id);
                    $("#delete").show();
                }
            });
        }
    });

    $("#delete").click(function() {
        $.ajax({
            type: "GET",
            url: "/timetable/delete/" + $("#id").val()
        });
    });

    $("#timetableRepetition").change(function(){
        var reps = $("#numberOfRepeats");
        var repsDesc = $("#repeatDescriptor");
        if($(this).val() == "0"){
            reps.prop("disabled" , true);
            repsDesc.html("");
        }else{
            reps.prop("disabled" , false);
        }
        switch($(this).val()){
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
});
