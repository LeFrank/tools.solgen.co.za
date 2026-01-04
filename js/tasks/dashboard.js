$(function () {

    $("#fromDate").datetimepicker();
    $("#toDate").datetimepicker();

    $("#searchExpand").click(function () {
        $("#filterSection").slideToggle("slow", function () {
            if ($("#filterSection").is(":visible")) {
                $(this).addClass("notesHistory");
            }
        });
    });

    $("#filter").click(function () {
        $.post(
                "/tasks/dashboard_filter",
                $("#filterTasksForm").serialize()
                ).done(function (resp) {
                    $("#dashboardContent").html("");
            $("#dashboardContent").html(resp).slideDown();
            // $('#taskSummary').tablesorter();
        });
    });
});

