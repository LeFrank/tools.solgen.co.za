$(document).ready(function () {
    $("#clearForm").click(function () {
        $("input[type=text], textarea").val("");
        $("#id").val("");
        $("input[type=checkbox]").attr("checked", false);
        $("#delete").hide();
        $("#clearForm").hide();
    });
    $(function () {
        $("#startDate").datetimepicker();
    });
    $(function () {
        $("#endDate").datetimepicker();
    });

    $("#search-timetable").click(function () {
        console.log($("#timetable-search-form").serialize());
        $.post(
                "/timetable/search/filtered",
                $("#timetable-search-form").serialize()
                ).done(function (resp) {
                    $("#search-entries").html(resp);
        });
    });
});
