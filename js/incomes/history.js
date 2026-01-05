$(document).ready(function () {
    $('#income_history').tablesorter();

    $(function () {
        $("#fromDate").datetimepicker();
        $("#toDate").datetimepicker();
    });

    $("#filter").click(function () {
        $.post(
                "/income/filter-search",
                $("#filterIncomeForm").serialize()
                ).done(function (resp) {
            $("#historyGraph").html(resp);
            $('#income_history').tablesorter();
        });
    });

    $("#incomePeriod").change(function () {
        if ($("#incomePeriod").val() == "0") {
            $("#fromDate").val(default_start_date);
            $("#toDate").val(default_end_date);
        } else {
            var selectedObj = getObjects(expense_period, "id", $("#incomePeriod").val());
            $("#fromDate").val(selectedObj[0]["start_date"]);
            $("#toDate").val(selectedObj[0]["end_date"]);

        }
    });

});
 