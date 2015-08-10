$(document).ready(function () {
    $("div .editable_content").on('click', function () {
        if (this.id.substring("body_")) {
            CKEDITOR.replace(this.id);
        }
    });
});

function confirm_delete() {
    return confirm('This will delete the note, are you sure?');
}