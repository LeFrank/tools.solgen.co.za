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

    const dropZone = document.getElementById("drop-zone");

    dropZone.addEventListener("drop", dropHandler);
    window.addEventListener("drop", (e) => {
    if ([...e.dataTransfer.items].some((item) => item.kind === "file")) {
        e.preventDefault();
    }
    });
    dropZone.addEventListener("dragover", (e) => {
    const fileItems = [...e.dataTransfer.items].filter(
        (item) => item.kind === "file",
    );
    if (fileItems.length > 0) {
        e.preventDefault();
        if (fileItems.some((item) => item.type.startsWith("image/"))) {
            e.dataTransfer.dropEffect = "copy";
        } else {
            e.dataTransfer.dropEffect = "none";
        }
    }
    });

    window.addEventListener("dragover", (e) => {
    const fileItems = [...e.dataTransfer.items].filter(
        (item) => item.kind === "file",
    );
    if (fileItems.length > 0) {
        e.preventDefault();
        if (!dropZone.contains(e.target)) {
            e.dataTransfer.dropEffect = "none";
        }
    }
    });
    const preview = document.getElementById("preview");

    function displayImages(files) {
    for (const file of files) {
        if (file.type.startsWith("image/")) {
            const li = document.createElement("li");
            const img = document.createElement("img");
            img.src = URL.createObjectURL(file);
            img.alt = file.name;
            li.appendChild(img);
            li.appendChild(document.createTextNode(file.name));
            preview.appendChild(li);
        }
    }
    }

    function dropHandler(ev) {
        ev.preventDefault();
        const files = [...ev.dataTransfer.items]
            .map((item) => item.getAsFile())
            .filter((file) => file);
        displayImages(files);
    }
    const fileInput = document.getElementById("file-input");
    fileInput.addEventListener("change", (e) => {
        displayImages(e.target.files);
    });
    const clearBtn = document.getElementById("clear-btn");
    clearBtn.addEventListener("click", () => {
        for (const img of preview.querySelectorAll("img")) {
            URL.revokeObjectURL(img.src);
        }
        preview.textContent = "";
    });
});