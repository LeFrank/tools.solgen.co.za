function getNotesForTag(ele) {
    var tagVal = $(ele).attr('rel');
    $.post(
            "/notes/tag/entries",
            {"tagVal": tagVal}
    ).done(function (resp) {
        $("#tag-content").html(resp);
    });
}