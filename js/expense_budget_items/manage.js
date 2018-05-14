$(function () {
    $("#periodBtn").click(function () {
        $("#baselineItems").slideToggle("slow", function () {
//            console.log("get a previous periods expense items");
            $.ajax({
                url: "/expense-budget-items/get-period-expense/" + budgetId +"/"+ periodId
            }).done(function (resp) {
                $('#baselineItems').html(resp);
            });
        });
    });

    $("#budgetBtn").click(function () {
        $("#baselineItems").slideToggle("slow", function () {
            console.log("get a previous budget's items");
        });
    });
    $("#typesBtn").click(function () {
        $("#baselineItems").slideToggle("slow", function () {
            console.log("get all all expense types, for population");
        });
    });
});