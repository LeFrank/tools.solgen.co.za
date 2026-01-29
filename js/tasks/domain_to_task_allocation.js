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
            "/tasks/domain-to-task-filter",
            $("#domain_to_task_filter_form").serialize()
        ).done(function (resp) {
                $("#domain_to_task_allocation_content").html("");
                $("#domain_to_task_allocation_content").html(resp).slideDown();
                // $('#taskSummary').tablesorter();
        });
    });
});

