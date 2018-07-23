$(document).ready(function() {
    if(document.getElementById("expenseSummary")){
        $('#expenseSummary').tablesorter();
    }
    if(document.getElementById("expense_history")){
        console.log("Ran");
        $('#expense_history').tablesorter();
    }
});