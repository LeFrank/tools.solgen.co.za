$(document).ready(function () {
    var url = window.location.href
    var arr = url.split("/");
    console.log(arr);
    $('#budget_expense_items').tablesorter();

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
                console.log(arr[0]);
                var prot = arr[0];
                var url = prot + "//" + window.location.host + "/expenses/getExpenses/" + replaceAll($(this).attr("data-expense-ids"), ",", "-") + "?keepThis=true&TB_iframe=true&width=850&height=500";
                console.log(url);
                tb_show("Expenses", url);
            }
        }
    });
    $("#remaining-for-period").click(function () {
        console.log("period-id: " + $("#period-id").val());
        console.log("category-id: " + $(this).attr("data-category"));
    });
});
function replaceAll(string, find, replace) {
    return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}

function escapeRegExp(string) {
    return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
}