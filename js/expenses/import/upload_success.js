$(document).ready(function () {
//    $('.editable').jinplace();
//    $('#budget_expense_items_over').tablesorter();
//    $('textarea').autoResize();
});

$("#remove-row").click(function(){
   console.log($(this).val()); 
});

function removeTabRow(id){
    $("#row_"+id).remove();
}