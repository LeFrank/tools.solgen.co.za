$(document).ready(function () {
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
    $('.editable').jinplace();
});

function recordEmotion(id) {
//    console.log(id);
//    delay(function () {
    $.ajax({
        method: "POST",
        url: "/health/emotion/record/" + id
    }).done(function (msg) {
//            alert("Data Saved: " + msg);

    });
//    }, 5000);
}

function emotionNameShow(emotion) {
//    console.log(emotion);
    $("#emotion-name").html(emotion);
}