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

    $("#exerciseType").click(function () {
        console.log($(this).find(":selected").attr("data-default_measurement_name"));
        var valu = $(this).find(":selected").attr("data-default_measurement_name");
        $("#measurement_value_label").text(valu);
    });

});

function updateExerciseEndDate(date) {
    $("#exerciseEndDate").attr("placeholder", date);
    $("#exerciseEndDate").datetimepicker({
        startDate: date
    });
}