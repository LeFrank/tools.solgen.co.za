$(document).ready(function() {
    $("#delete-account").click(function() {
        var r = confirm("Are you sure you wish to delete your account and all your data?");
        if (r == true)
        {
            $.post("/user/delete-account").done(function(resp) {
                $("#setting-feedback").append(resp);
            });
        }
    });
    $("#unsubscribe").click(function() {
        var subscribed = $("#unsubscribe").is(':checked');
        $("#loading").show();
        var res = "";
        $.ajax({
            url: '/user/email/unsubscribe',
            type: 'POST',
            data: {"subscribed": subscribed , "user_id": user_id}
        }).done(function(resp){
            $("#email-subscribed-status").html(resp);
            $("#loading").hide();
        }).error(function(err){
            $("#loading").hide();
        });
    });
});
