$(document).ready(function() {
    $("input:radio[name=measurement]").click(function() {
        //save measurement change to db
        $.ajax({
            type:"POST",
            url: "/weather/measurement/",
            data: {"measurement":$(this).val()}
        }).done(function(resp){
            var oImg=document.createElement("img");
            oImg.setAttribute('src', '/images/third_party/icons/check35.png');
            oImg.setAttribute('height', '15px');
            oImg.setAttribute('width', '20px');
            $("#measurement-stat").html(oImg);
        });
    });
});

    