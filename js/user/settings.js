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

});
