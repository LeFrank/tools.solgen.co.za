$(document).ready(function () {
    $('.editable').jinplace();
    CKEDITOR.replace('description');
    $("#start_date").datetimepicker();
    $("#end_date").datetimepicker();
    $("#target_date").datetimepicker();

    $("#toggle_data").click(function(){
        var noteId = $(this).attr("data");
        var contentDiv = $("#content_" + noteId);
        console.log(noteId + " - " + contentDiv.is(":visible"));
        if(contentDiv.is(":visible")){
            contentDiv.hide();
            $(this).removeClass("fa-minus-square").addClass("fa-plus-square");
        } else {
            contentDiv.show("slow");
            $(this).removeClass("fa-plus-square").addClass("fa-minus-square");
        }
    });
});