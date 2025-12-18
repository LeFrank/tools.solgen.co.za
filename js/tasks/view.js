$(document).ready(function () {
    $('#taskSummary').tablesorter();
    $('input[type="checkbox"]').click(function() {
        if($(this).prop("checked") == true) {
            // alert("Checkbox is checked.");
            console.log("Checked: " + $(this).val());
            //ToDo: Enable the lines below to make it functional
            $.post(
                "/tasks/mark-as-done/" + $(this).val(),
                null
            ).done(function (resp) {
                // console.log(resp);
                console.log("Task marked as done.");
                let resp_value = JSON.parse(resp);
                console.log(resp_value["status"]);
                console.log(resp_value["message"]);
            });
        }else{
            // alert("Checkbox is unchecked.");
            console.log("Unchecked: " + $(this).val());
            //mark-as-undone
            $.post(
                "/tasks/mark-as-undone/" + $(this).val(),
                null
            ).done(function (resp) {
                console.log(resp);
            });
        }
    });
});
