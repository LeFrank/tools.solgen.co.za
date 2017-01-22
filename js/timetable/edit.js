var formatDate = "yy-mm-dd";
$(document).ready(function () {
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
});