$(document).ready(function () {
    $('#tasks_history').tablesorter();

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
            $('#tasks_history').tablesorter();
        });
    });
});
 