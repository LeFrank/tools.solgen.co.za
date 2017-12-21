$(document).ready(function () {
    $('#wishlistItems').tablesorter();
    $("#fromDate").datetimepicker();
    $("#toDate").datetimepicker();
    
    $("#filter").click(function () {
        $.post(
                "/wishlist/filter-search",
                $("#filterWishlistForm").serialize()
                ).done(function (resp) {
                    $("#latestItems").html(resp);
            $('#wishlistItems').tablesorter();
        });
    });
});

function confirm_delete() {
    return confirm('This will delete the Wishlist Item, are you sure?');
}

$("#expensePeriod").change(function () {
        if ($("#expensePeriod").val() == "0") {
            $("#fromDate").val(default_start_date);
            $("#toDate").val(default_end_date);
        } else {
            var selectedObj = getObjects(expense_period, "id", $("#expensePeriod").val());
            $("#fromDate").val(selectedObj[0]["start_date"]);
            $("#toDate").val(selectedObj[0]["end_date"]);

        }
    });