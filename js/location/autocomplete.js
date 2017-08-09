$(function () {
    $("#location").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "/location/search/json/" + request.term,
                dataType: "json",
                success: function (data) {
                    response(data);
                },
                done: function(){
                    $("#locationId").val("0");
                },
                complete: function(responseObj, textStatus){
                    if(responseObj.responseJSON == "" || textStatus == "error"){
                        $("#locationId").val("");
                    }
                }
            });
        },
        minLength: 2,
        select: function (event, ui) {
            if(ui !== undefined){
                $("#locationId").val(ui.item.id);
                $("#location").val(""+ui.item.label);
            }else{
                $("#locationId").val("");
            }
        }
    });
});