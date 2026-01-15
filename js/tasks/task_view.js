$(document).ready(function () {
    $('.editable').jinplace();
    CKEDITOR.replace('description');
    $("#start_date").datetimepicker();
    $("#end_date").datetimepicker();
    $("#target_date").datetimepicker();

    $("#toggle_data").click(function(){
        var noteId = $(this).attr("data");
        var contentDiv = $("#content_" + noteId);
        console.log(noteId + " - " + contentDiv.is(":visible"));
        if(contentDiv.is(":visible")){
            contentDiv.hide();
            $(this).removeClass("fa-minus-square").addClass("fa-plus-square");
        } else {
            contentDiv.show("slow");
            $(this).removeClass("fa-plus-square").addClass("fa-minus-square");
        }
    });

    

    //     var obj = $(this);
    //     /* ADD FILE TO PARAM AJAX */
    //     var formData = new FormData();
    //     $.each($(obj).find("input[type='file']"), function(i, tag) {
    //         $.each($(tag)[0].files, function(i, file) {
    //             formData.append(tag.name, file);
    //         });
    //     });
    //     var params = $(obj).serializeArray();
    //     $.each(params, function (i, val) {
    //         formData.append(val.name, val.value);
    //     });
    //     return formData;
    // };
    
    $("#upload-artefact-button").click(function () {
        
        // var data = new FormData($("#upload-artefact-form").serializeArray()); // <-- 'this' is your form element
        var formData = new FormData($('#upload-artefact-form')[0]);
        params   = $('#upload-artefact-form').serializeArray();

        $.each(params, function(i, val) {
            formData.append(val.name, val.value);
        });
        console.log(formData)
        $.ajax({
                url: "/tasks/task/" + $("#taskId").val() + "/upload-artefact",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',     
                success: function(data){
                    $("#artefact-list-view").html("Artefacts Uploaded Successfully");
                    delay(function(){
                    $("#artefact-list-view").html(data);
                    $("#upload-artefact-form")[0].reset();
                },5000);
            },
        });
    });   

    // $("#upload-artefact-button").click(function () {
    //     console.log("Uploading artefact for task ID: " + $("#taskId").val());
    //     console.log($("#task-artefacts").val());
    //     console.log($('#task-artefacts')[0]);
    //     console.log($('#task-artefacts').files());
    //     // console.log($("#upload-artefact-form").serializefiles());
    //     var data = new FormData($('#task-artefacts'));     
    //     jQuery.each($('#task-artefacts')[0].files, function(i, file) {
    //         data.append(i, file);
    //     });

    //     $.ajax({
    //         method: "POST",
    //         url: "/tasks/task/" + $("#taskId").val() + "/upload-artefact",
    //         data: data,
    //         success: function(data){
    //             $("#artefact-list-view").html("Artefacts Uploaded Successfully");
    //             delay(function(){
    //                 $("#artefact-list-view").html(data);
    //                 $("#upload-artefact-form")[0].reset();
    //             },5000);
    //         },
    //     });
    // });

    // $.ajax({
    //     method: "POST",
    //     url: "tasks/task/" + $("#taskId").val() + "/artefacts",
    //     data: {overall_comment: $("#"+ele).val()}
    // }).done(function (msg) {
    //     $("#post_budget_comment_status").html("Data Saved");
    //     delay(function(){
    //         $("#post_budget_comment_status").html("");
    //     },5000);
    // });


    // const dropZone = document.getElementById("drop-zone");

    // dropZone.addEventListener("drop", dropHandler);
    // window.addEventListener("drop", (e) => {
    // if ([...e.dataTransfer.items].some((item) => item.kind === "file")) {
    //     e.preventDefault();
    // }
    // });
    // dropZone.addEventListener("dragover", (e) => {
    //     const fileItems = [...e.dataTransfer.items].filter(
    //         (item) => item.kind === "file",
    //     );
    //     for (const item of fileItems) {
    //         console.log(item.type);
    //     }
    //     if (fileItems.length > 0) {
    //         e.preventDefault();
    //         // console.log(fileItems);
    //         if (fileItems.some((item) => item.type.startsWith("image/"))) {
    //             e.dataTransfer.dropEffect = "copy";
    //         } else if (fileItems.every((item) => item.type.startsWith("application/"))) {
    //             // console.log("pdf: GOT HERE");
    //             e.dataTransfer.dropEffect = "copy";
    //         } else if (fileItems.every((item) => item.type.startsWith("text/"))) {
    //             // console.log("text: GOT HERE");
    //             e.dataTransfer.dropEffect = "copy";
    //         } 
    //         else {
    //             e.dataTransfer.dropEffect = "none";
    //         }
    //     }
    // });

    // window.addEventListener("dragover", (e) => {
    // const fileItems = [...e.dataTransfer.items].filter(
    //     (item) => item.kind === "file",
    // );
    // if (fileItems.length > 0) {
    //     e.preventDefault();
    //     if (!dropZone.contains(e.target)) {
    //         e.dataTransfer.dropEffect = "none";
    //     }
    // }
    // });
    // const preview = document.getElementById("preview");

    // function displayImages(files) {
    // for (const file of files) {
    //     if (file.type.startsWith("image/")) {
    //         const li = document.createElement("li");
    //         const img = document.createElement("img");
    //         img.src = URL.createObjectURL(file);
    //         img.alt = file.name;
    //         li.appendChild(img);
    //         li.appendChild(document.createTextNode(file.name));
    //         preview.appendChild(li);
    //     }
    // }
    // }

    // function dropHandler(ev) {
    //     ev.preventDefault();
    //     const files = [...ev.dataTransfer.items]
    //         .map((item) => item.getAsFile())
    //         .filter((file) => file);
    //     for (const item of files) {
    //         console.log(item.type);
    //         console.log(item.name);
    //     }
    //     displayImages(files);
    // }
    // const fileInput = document.getElementById("file-input");
    // fileInput.addEventListener("change", (e) => {
    //     displayImages(e.target.files);
    // });
    // const clearBtn = document.getElementById("clear-btn");
    // clearBtn.addEventListener("click", () => {
    //     for (const img of preview.querySelectorAll("img")) {
    //         URL.revokeObjectURL(img.src);
    //     }
    //     preview.textContent = "";
    // });
});