$(document).ready(function () {
    var url = window.location.href
    var arr = url.split("/");
    $('#budget_expense_items_over').tablesorter();
    $('#budget_expense_items_under').tablesorter();

    // Make table cell focusable
    // http://css-tricks.com/simple-css-row-column-highlighting/
    if ($('.focus-highlight').length) {
        $('.focus-highlight').find('td, th')
                .attr('tabindex', '1')
                // add touch device support
                .on('touchstart', function () {
                    $(this).focus();
                });
    }

    $("td").click(function () {
        if ($(this).attr("id") === "spent-to-date") {
            if ($(this).attr("data-expense-count") > 0) {
                var url = arr[0] +"://" + window.location.host + "/expenses/getExpenses/" + replaceAll($(this).attr("data-expense-ids"), ",", "-") + "?keepThis=true&TB_iframe=true&width=850&height=500";
                tb_show("Expenses", url);
            }
        }
    });
    $("#remaining-for-period").click(function () {
        console.log("period-id: " + $("#period-id").val());
        console.log("category-id: " + $(this).attr("data-category"));
    });

    $('.editable').jinplace();
});


function replaceAll(string, find, replace) {
    return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}

function escapeRegExp(string) {
    return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
}

function saveContent(ele) {
    delay(function () {
        $.ajax({
            method: "POST",
            url: "/expense-budget-item/comment/" + $(ele).prev().val(),
            data: {comment: $(ele).val()}
        }).done(function (msg) {
            alert("Data Saved: " + msg);
        });
    }, 5000);
}

function saveBudgetOverSpendComment(ele) {
    $.ajax({
        method: "POST",
        url: "/expense-budget/comment/" + $("#budgetId").val(),
        data: {over_spend_comment: $("#"+ele).val()}
    }).done(function (msg) {
        $("#overspend_comment_status").html("Data Saved");
        delay(function(){
            $("#overspend_comment_status").html("");
        },5000);
    });
}

function saveBudgetUnderSpendComment(ele) {
    $.ajax({
        method: "POST",
        url: "/expense-budget/comment/" + $("#budgetId").val(),
        data: {under_spend_comment: $("#"+ele).val()}
    }).done(function (msg) {
        $("#underspend_comment_status").html("Data Saved");
        delay(function(){
            $("#underspend_comment_status").html("");
        },5000);
    });
}

function saveBudgetOverallComment(ele) {
    $.ajax({
        method: "POST",
        url: "/expense-budget/comment/" + $("#budgetId").val(),
        data: {overall_comment: $("#"+ele).val()}
    }).done(function (msg) {
        $("#post_budget_comment_status").html("Data Saved");
        delay(function(){
            $("#post_budget_comment_status").html("");
        },5000);
    });
}
