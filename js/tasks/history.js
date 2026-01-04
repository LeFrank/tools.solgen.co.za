$(document).ready(function () {
    $('#taskSummary').tablesorter();

    $(function () {
        $("#fromDate").datetimepicker();
        $("#toDate").datetimepicker();
    });

    $("#filter").click(function () {
        $.post(
                "/tasks/filter-search",
                $("#filterTasksForm").serialize()
                ).done(function (resp) {
            $("#historyGraph").html(resp);
            $('#taskSummary').tablesorter();
        });
    });
});
 