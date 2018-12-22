$(document).ready(function () {
    $('.editable').jinplace();
    
    $("#auto_save").change(function(){
        console.log("Checked = " + $(this).is(":checked"));
        var chcked = ($(this).is(":checked"))? 1 : 0;
        console.log($(this).attr("data-id"));
        console.log(chcked);
        // Update the auto save note user configuration
        $.ajax({
            method: "POST",
            url: "/notes/option/update/" + $(this).attr("data-id"),
            data: {value: chcked }
        }).done(function (msg, resp) {
            console.log("msg: "+ msg);
            console.log("resp: "+ resp);
            if(resp === "success"){
//                $("#note_status").html("Note Auto-saved");
//                currentContentLength = CKEDITOR.instances['body'].getData().length;
//                delay(function(){
//                    $("#note_status").html("Last Auto-save: " + moment().format('hh:mm:ss') );
//                },5000);
            }
        });
    });
});