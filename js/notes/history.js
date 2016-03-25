$(function () {
    $("#searchExpand").click(function () {
        $("#searchForm").slideToggle("slow", function () {
            if ($("#searchForm").is(":visible")) {
                $(this).addClass("notesHistory");
                $("#searchText").focus();
            }
        });
    });
    $("#createNote").click(function () {
        $("#createNoteForm").slideToggle("slow", function () {
            if ($("#createNoteForm").is(":visible")) {
                $(this).addClass("notesHistory");
                $("#title").focus();
            }
        });
    });
    $("#cancel-new-note").click(function () {
        $("#createNoteForm").slideToggle("slow", function () {
            if ($("#createNoteForm").is(":visible")) {
                $(this).addClass("notesHistory");
            }
        });
    });
    $("#fromDate").datetimepicker();
    $("#toDate").datetimepicker();

    $(".show-content").click(function () {
        var note_id = $(this).attr("data-note-id");
        if ($("#body_content_" + note_id).hasClass("notes_body_clamp")) {
            $("#body_content_" + note_id).removeClass("notes_body_clamp");
            $(this).html("Show less");
        } else {
            $("#body_content_" + note_id).addClass("notes_body_clamp");
            $(this).html("Show More");
        }
    });
});