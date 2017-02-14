$(document).ready(function () {
    $('#expense_history').tablesorter();

    $(function () {
        $("#fromDate").datetimepicker();
        $("#toDate").datetimepicker();
    });

    $("#filter").click(function () {
        $.post(
                "/expenses/filter-search",
                $("#filterExpenseForm").serialize()
                ).done(function (resp) {
            $("#historyGraph").html(resp);
            $('#expense_history').tablesorter();
        });
    });

    $("#expensePeriod").change(function () {
        if ($("#expensePeriod").val() == "0") {
            $("#fromDate").val(default_start_date);
            $("#toDate").val(default_end_date);
        } else {
            var selectedObj = getObjects(expense_period, "id", $("#expensePeriod").val());
            $("#fromDate").val(selectedObj[0]["start_date"]);
            $("#toDate").val(selectedObj[0]["end_date"]);

        }
    });

});
 