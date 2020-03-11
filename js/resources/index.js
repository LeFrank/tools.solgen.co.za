$(document).ready(function () {
    CKEDITOR.replace("description");
});
Dropzone.autoDiscover = false;
$(function() {
    //Dropzone class
    var myDropzone = new Dropzone(".dropzone", {
		url: "resources/do_upload",
		paramName: "file",
		maxFilesize: 2,
		maxFiles: 10,
		acceptedFiles: "image/*,application/pdf, text/*",
                autoProcessQueue: false
	});
        $('#startUpload').click(function(){           
		myDropzone.processQueue();
	});
});