$(document).ready(function() {
    if(document.getElementById("incomeSummary")){
        $('#incomeSummary').tablesorter();
    }
    if(document.getElementById("income_history")){
        console.log("Ran");
        $('#income_history').tablesorter();
    }
});