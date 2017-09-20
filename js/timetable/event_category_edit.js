/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

//    $("#textColour").change(function () {
//        $("#event-cat-sample-text").attr("color", $("#textColour").val());
//    });
//    $("#textColour").change(function () {
//        $("#event-cat-sample-text").attr("color", $("#textColour").val());
//    });
});


function changeColour(t) {
    $("#event-cat-sample-text").css("color", t.value);
}

function changeBGColour(t) {
    $("#event-cat-sample-text").css("backgroundColor", t.value);
}

//console.log("loaded");
