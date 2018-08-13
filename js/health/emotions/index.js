$(document).ready(function () {
    console.log("test");
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

function emotionNameShow(emotion){
//    console.log(emotion);
    $("#emotion-name").html(emotion);
}