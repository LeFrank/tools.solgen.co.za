$(function () {

});

//function getWishlistItemsForPeriod(ele) {
//    console.log("got here");
//    console.log($(ele).val());
////    console.log($("#budgetForm").serialize());
//    $.post(
//            "/wishlist/filter-search",
//            "id=" + $(ele).val()
//            ).done(function (resp) {
//        console.log(resp);
//    });
//}
$("#expensePeriod").change(function () {
    if ($("#expensePeriod").val() == "0") {
    //    $("#fromDate").val(default_start_date);
    //    $("#toDate").val(default_end_date);
        console.log("do nothing");
    } else {
        var selectedObj = getObjects(expense_period, "id", $("#expensePeriod").val());
    //    $("#fromDate").val(selectedObj[0]["start_date"]);
    //    $("#toDate").val(selectedObj[0]["end_date"]);
//        console.log(selectedObj[0]["start_date"]);
//        console.log(selectedObj[0]["end_date"]);
        $.post(
            "/wishlist/filter-search",
            "fromDate=" + selectedObj[0]["start_date"] + "&toDate="+selectedObj[0]["end_date"] + "&includeActions=false"
        ).done(function (resp) {
//            console.log(resp);
            $("#wishlist-items-for-period").html(resp);
        });
    }
});