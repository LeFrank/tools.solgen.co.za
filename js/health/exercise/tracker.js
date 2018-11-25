$(function () {

    $("#exerciseStartDate").datetimepicker({
        onClose: function () {
            updateExerciseEndDate($("#exerciseStartDate").val());
        }
    });
    $("#exerciseEndDate").datetimepicker();

    $(function () {
        $("#fromDate").datetimepicker();
    });
    $(function () {
        $("#toDate").datetimepicker();
    });

    
    CKEDITOR.replace('description');
    $("#exerciseType").change(function () {
        var valu = $(this).find(":selected").attr("data-default_measurement_name");
        $("#measurement_value_label").text(valu);
    });
    $('#health_exercise_tracker_history').tablesorter();
});

function updateExerciseEndDate(date) {
    $("#exerciseEndDate").attr("placeholder", date);
    $("#exerciseEndDate").datetimepicker({
        startDate: date
    });
}