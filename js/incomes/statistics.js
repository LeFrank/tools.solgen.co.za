$(document).ready(function() {
    var url = window.location.href
    var arr = url.split("/");
    $(function() {
        $("#fromDate").datetimepicker();
        $("#toDate").datetimepicker();
    });
    
    $("#expensePeriod").change(function () {
        if ($("#expensePeriod").val() == "0") {
            $("#fromDate").val(default_start_date);
            $("#toDate").val(default_end_date);
        }else{
            var selectedObj = getObjects(expense_period, "id", $("#expensePeriod").val());
            $("#fromDate").val(selectedObj[0]["start_date"]);
            $("#toDate").val(selectedObj[0]["end_date"]);
            
        }
    });

});
