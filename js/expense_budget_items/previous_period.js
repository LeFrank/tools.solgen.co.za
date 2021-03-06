$(function () {
    var url = window.location.href
    var arr = url.split(":");
    $('[id^=expenseType]').change(function () {
        console.log("234323423");
        var total = parseFloat("0");
        var expenseTypeArr = $('[id^=epenseType]');
        for (i = 0; i < expenseTypeArr.length; i++) {
//            console.log($(expenseTypeArr[i]).val());
            if (isNumber($(expenseTypeArr[i]).val())) {
                total = total + parseFloat($(expenseTypeArr[i]).val());
            }
        }
        var unassigned =  parseFloat($("#currentBudgetCeiling").val().replace(",","") ).toFixed(2) - total;
        if(parseFloat(total) > parseFloat($("#currentBudgetCeiling").val().replace(",","") )){
            $("#assignmenTxt").html("Items Overrun Limit by: ");
        }else{
            $("#assignmenTxt").html("Unassigned Funds: ");
        }
        $("#unassigned").html(parseFloat(unassigned).toFixed(2));
//        console.log(parseFloat($("#currentBudgetCeiling").val()).toFixed(2) - parseFloat(total).toFixed(2));
        
        var assigned = parseFloat(total).toFixed(2);
        $("#assigned").html(parseFloat(assigned).toFixed(2));
    });
    
    $("td").click(function () {
        if ($(this).attr("id") === "previous-period-type") {
            if ($(this).attr("data-expense-count") > 0) {
                var url = arr[0] + "://" + window.location.host + "/expenses/getExpenses/" + replaceAll($(this).attr("data-expense-ids"), ",", "-") + "?keepThis=true&TB_iframe=true&width=850&height=500";
                tb_show("Expenses", url);
            }
        }
    });
    $("td").click(function () {
        if ($(this).attr("id") === "previous-period-type") {
            if ($(this).attr("data-expense-count") > 0) {
                var ids = replaceAll($(this).attr("data-expense-ids"), ",", "-")
                var url = arr[0] +"://" + window.location.host + "/expenses/getExpenses/" + replaceAll($(this).attr("data-expense-ids"), ",", "-") + "?keepThis=true&TB_iframe=true&width=850&height=500";
                tb_show("Expenses", url);
            }
        }
    });
});

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}