$(function () {
    $("#tag").click(function () {
        console.log("clicked");
        console.log($(this).val());
    });
});

function getNotesForTag(ele) {
    var tagVal = $(ele).attr('rel');
    $.post(
            "/notes/tag/entries",
            {"tagVal": tagVal}
    ).done(function (resp) {
        console.log(resp);
    });
}