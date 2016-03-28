$(document).ready(function () {
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
                var url = "http://" + window.location.host + "/expenses/getExpenses/" + replaceAll($(this).attr("data-expense-ids"), ",", "-") + "?keepThis=true&TB_iframe=true&width=850&height=500";
                tb_show("Expenses", url);
            }
        }
    });
    $("#remaining-for-period").click(function () {
        console.log("period-id: " + $("#period-id").val());
        console.log("category-id: " + $(this).attr("data-category"));
    });
});
var delay = (function () {
    var timer = 0;
    return function (callback, ms) {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
    };
})();

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
