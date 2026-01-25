$(document).ready(function () {
    $('#taskSummary').tablesorter();
    toastr.options = {
                closeButton: true,
                onclick: null
    };
    $('input.tasks_checkbox[type="checkbox"]').click(function() {
        // console.log("tasks_checkbox clicked");
        let task_id = $(this).val();
        if( $(this).prop("checked") == true ){
            // console.log("Checked: " + $(this).val());
            $.post(
                "/tasks/mark-as-done/" + $(this).val(),
                null
            ).done(function (resp) {
                let resp_value = JSON.parse(resp);
                // console.log(resp_value["status"] +"" + resp_value["message"]);
                if(resp_value["status"] == "success"){
                    // console.log(resp["message"]);
                    toastr.success(resp_value["message"]);
                    // console.log($("#row_"+task_id).html());
                    // console.log($(".row_"+ task_id).html());
                    $("#row_"+task_id).css({"background-color": "#c5f4b8", "color": "#007502"});
                    // $();
                } else {
                    // console.log(resp);
                    toastr.error(resp_value["message"]);
                }
            });
        }else{
            // console.log("Unchecked: " + $(this).val());
            $.post(
                "/tasks/mark-as-undone/" + $(this).val(),
                null
            ).done(function (resp) {
                let resp_value = JSON.parse(resp);
                // console.log(resp_value["status"] +"" + resp_value["message"]);
                if(resp_value["status"] == "success"){
                    // console.log(resp["message"]);
                    toastr.success(resp_value["message"]);
                    $("#row_"+task_id).css({"background-color": "inherit", "color": "inherit"});
                } else {
                    // console.log(resp);
                    toastr.error(resp_value["message"]);
                }
            });
        }
    });
});