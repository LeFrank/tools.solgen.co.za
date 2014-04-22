$(document).ready(function() {
    $("#delete-account").click(function() {
        var r = confirm("Are you sure you wish to delete your account and all your data?");
        if (r == true)
        {
            $("#setting-feedback").addClass("success");
            $("#setting-feedback").append("TESTING !@#");
        }else{
            $("#setting-feedback").addClass("failure");
            $("#setting-feedback").append("TESTING !@#");
        }
//        $.post("/user/delete-account").done(function(resp) {
//        });
    });

});
