$(document).ready(function () {
    $('#wishlistItems').tablesorter();
    $("#fromDate").datetimepicker();
    $("#toDate").datetimepicker();
    
    $("#filter").click(function () {
        $.post(
                "/expense-wishlist/filter-search",
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