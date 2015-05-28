$(function () {
    $("#searchExpand").click(function () {
        $("#searchForm").slideToggle("slow",function(){
            if($("#searchForm").is(":visible")){
                $(this).addClass("notesHistory");
            }
        });
    });
    $("#createNote").click(function () {
        $("#createNoteForm").slideToggle("slow",function(){
            if($("#createNoteForm").is(":visible")){
                $(this).addClass("notesHistory");
            }
        });
    });
    $("#cancel-new-note").click(function(){
        $("#createNoteForm").slideToggle("slow",function(){
            if($("#createNoteForm").is(":visible")){
                $(this).addClass("notesHistory");
            }
        });
    });
    $("#fromDate").datetimepicker();
    $("#toDate").datetimepicker();
});