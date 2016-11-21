$(document).ready(function () {
    $('#wishlistItems').tablesorter();
});

function confirm_delete() {
    return confirm('This will delete the Wishlist Item, are you sure?');
}