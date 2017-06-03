$(document).ready(function () {
    $("div .editable_content").on('click', function () {
        if (this.id.substring("body_")) {
            CKEDITOR.replace(this.id);
        }
    });
});
