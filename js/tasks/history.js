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

    $('input.tasks_checkbox[type="checkbox"]').click(function() {
        // console.log("tasks_checkbox clicked");
        if( $(this).prop("checked") == true ){
            // console.log("Checked: " + $(this).val());
            $.post(
                "/tasks/mark-as-done/" + $(this).val(),
                null
            ).done(function (resp) {
                // let resp_value = JSON.parse(resp);
                // console.log(resp);
            });
        }else{
            // console.log("Unchecked: " + $(this).val());
            $.post(
                "/tasks/mark-as-undone/" + $(this).val(),
                null
            ).done(function (resp) {
                // console.log(resp);
            });
        }
    });

   

    $("#searchExpand").click(function () {
        $("#dashboardContent").slideToggle("slow", function () {
            if ($("#dashboardContent").is(":visible")) {
                $(this).addClass("notesHistory");
            }else{
                $(this).removeClass("notesHistory");
            }
        });
    });
});
 